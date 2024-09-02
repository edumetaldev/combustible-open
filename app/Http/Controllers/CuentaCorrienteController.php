<?php

namespace App\Http\Controllers;

use Validator;
use App\CuentaCorriente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as DB;
use App\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\Movimiento;

class CuentaCorrienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $movimiento;

    public function __construct( Movimiento $movimiento)
    {
        $this->movimiento = $movimiento;

    }
    public function index()
    {
        $ultimaslineas = DB::table('cuenta_corriente')
                          ->select('usuario_id',DB::raw('max(linea) as linea'))
                          ->groupby('usuario_id');

        $query = DB::table('cuenta_corriente')
              ->joinSub($ultimaslineas,'cc', function($join){
                  $join->on('cuenta_corriente.usuario_id','=','cc.usuario_id');
                  $join->on('cuenta_corriente.linea','=','cc.linea');
              })
              ->join('usuarios', 'cuenta_corriente.usuario_id','=','usuarios.id')
              ->select('cuenta_corriente.id','usuarios.nombre', 'usuarios.dni', 'cuenta_corriente.usuario_id', 'cuenta_corriente.linea', 'cuenta_corriente.saldo');

              $orderby = $this->getOrden(request('ordenarpor'));
              list($searchby,$search)= $this->getBuscar(request('buscarpor'),request('buscar'));

              if ($searchby){
                $query = $query->where($searchby,'like','%'.$search.'%');
              }

              if (request('excel')){
                $query = $query->select('usuarios.nombre as cuenta', 'cuenta_corriente.linea as lineas', 'cuenta_corriente.saldo as saldo'
                       );
                $datos = json_decode( json_encode($query->get()), true);
                Excel::create('Cuentas', function($excel) use($datos){
                      $excel->sheet('Excelsheet', function($sheet) use($datos){
                          $sheet->with($datos, null, 'A1', true);
                          $sheet->setOrientation('landscape');
                      });
                  })->download('xlsx');
              }
              $perpage = $this->getPaginacion(request('paginacion'));

              $cc = $query->paginate($perpage);

              $cc->appends(['ordenarpor' => $orderby]);
              $cc->appends(['paginacion' => $perpage]);
              $cc->appends(['buscarpor' => $searchby]);
              $cc->appends(['buscar' => $search]);

        return view('cuentacorriente.index',compact('cc'));
    }

    public function getPaginacion($perpage)
    {
      if ($perpage > 0){
          return $perpage;
      }
      return 10;
    }
    public function getBuscar($searchby,$search)
    {
        if ($searchby =='dni'){
          return ['dni',$search];
        }
        if ($searchby =='email'){
          return ['email',$search];
        }
        if ($searchby =='nombre'){
          return ['nombre',$search];
        }
        if ($searchby =='origen'){
          return ['uo.nombre',$search];
        }
        if ($searchby == 'destino'){
          return ['ud.nombre',$search];
        }
        return '';
    }
    public function getOrden($orderby)
    {
        if($orderby == 'dni'){
          return 'dni';
        }
        if($orderby == 'email'){
          return 'email';
        }
        if($orderby == 'nombre'){
          return 'nombre';
        }

        if($orderby == 'created_at'){
          return 'created_at';
        }

        return 'id';
    }
    public function transferir($id){

      $cuentas = DB::table('usuarios')
            ->where([['usuarios.es_cuenta_principal','=','1'],['usuarios.id','<>',$id]])
            ->select('id','nombre')
            ->get();
      $nombre = User::where('id',$id)->value('nombre');
      return view('cuentacorriente.transferir',['id' => $id,'cuentas' => $cuentas,'nombre' => $nombre]);
    }

    public function iniciar($id){

      $cuentas = DB::table('usuarios')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('cuenta_corriente')
                      ->whereRaw('cuenta_corriente.usuario_id = usuarios.id');

            })
            ->where('usuarios.es_cuenta_principal','=','1')
            ->select('id','nombre')
            ->get();
      return view('cuentacorriente.iniciar',['cuentas' => $cuentas]);
    }

    public function depositar($id){
      $nombre = User::where('id',$id)->value('nombre');

      return view('cuentacorriente.depositar',['id' => $id,'nombre' => $nombre]);
    }

    public function extraer($id){

      $nombre = User::where('id',$id)->value('nombre');

      return view('cuentacorriente.extraer',['id' => $id,'nombre' => $nombre]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cuenta_origen_id  = request('cuenta_origen_id');
        $cuenta_destino_id  = request('cuenta_destino_id');
        $monto = request('monto');
        $comentario = request('comentarios');
        $tipo_movimiento = request('tipo_movimiento');

      if ( $tipo_movimiento == 'transferencia' ){

          $saldo = DB::table('cuenta_corriente')
              ->where('usuario_id','=', $cuenta_origen_id )
              ->orderBy('id','desc')
              ->limit(1)
              ->value('saldo');

          $datos = $request->all();
          $datos['saldo'] =  $saldo - $monto;
          Validator::make($datos, [
              'saldo' => [
                  'numeric',
                  'min:0',
              ],
          ],
          [
            'saldo.min' => 'Saldo insuficiente'
          ])->validate();

        $this->movimiento->Transferir($cuenta_origen_id,$cuenta_destino_id,$monto,$comentario);

      }

      if ( $tipo_movimiento == 'deposito' ){
          $this->movimiento->Depositar($cuenta_origen_id,$monto,$comentario);
      }

      if ( $tipo_movimiento == 'extraccion' ){

        $datos = $request->all();
        $datos['saldo'] =  $this->movimiento->ObtenerCuentaSaldo($cuenta_origen_id)->saldo - $monto;
        Validator::make($datos, [
            'saldo' => [
                'numeric',
                'min:0',
            ],
        ],
        [
          'saldo.min' => 'Saldo insuficiente'
        ])->validate();

        $this->movimiento->Extraer($cuenta_origen_id,$monto,$comentario);
      }

      return redirect()->route('cuentacorriente.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CuentaCorriente  $cuentaCorriente
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $linea = DB::table('cuenta_corriente')
                           ->groupby('usuario_id')
                           ->where('usuario_id','=',$id)
                           ->value(DB::raw('max(linea) as linea'));

        $cuenta = DB::table('cuenta_corriente')
                           ->join('usuarios','usuarios.id','=', 'cuenta_corriente.usuario_id')
                           ->where([['linea' ,'=', $linea], ['usuario_id','=',$id]])
                           ->select('saldo','linea as lineas','usuarios.nombre')
                           ->get();
        list($searchby,$search)= $this->getBuscar(request('buscarpor'),request('buscar'));


        $query = DB::table(DB::raw('cuenta_corriente cc'))
                     ->leftJoin(DB::raw('usuarios as u'), 'cc.usuario_id','=','u.id')
                     ->leftJoin(DB::raw('usuarios as uo'), 'cc.usuario_id_origen','=','uo.id')
                     ->leftJoin(DB::raw('usuarios as ud'), 'cc.usuario_id_destino','=','ud.id')
                     ->leftJoin(DB::raw('usuarios as ur'), 'cc.audi_usuario_id','=','ur.id')
                     ->leftJoin(DB::raw('estaciones as es'), 'cc.estacion_id','=','es.id')
                     ->leftJoin(DB::raw('usuarios as co'), 'cc.usuario_id_consumidor','=','co.id')
                 ->select('cc.usuario_id_destino as destino_id','cc.usuario_id_origen as origen_id','cc.linea','u.nombre as cuenta', 'cc.tipo_movimiento', 'cc.saldo',
                          'cc.monto','cc.created_at as momento','ud.nombre as destino','uo.nombre as origen',
                          'cc.comentarios', 'ur.nombre as realizado_por', 'es.nombre as estacion', 'co.nombre as consumidor','co.oficina as consumidor_of', 'cc.created_at as fecha'
                          )
                 ->where('cc.usuario_id',$id)
                 ->orderby('cc.linea','desc');
        if ($searchby){
           $query = $query->where($searchby,'like','%'.$search.'%');
        }
        if (request('fecha_desde')){
          $query = $query->where(DB::raw('DATE(cc.created_at)'),'>=',request('fecha_desde'));
        }
        if (request('fecha_hasta')){
          $query = $query->where(DB::raw('DATE(cc.created_at)'),'<=',request('fecha_hasta'));
        }

        if (request('excel')){
          $query = $query->select('cc.linea','u.nombre as cuenta', 'cc.tipo_movimiento', 'cc.saldo',
                   'cc.monto','cc.created_at as momento','ud.nombre as destino','uo.nombre as origen',
                   'cc.comentarios', 'ur.nombre as realizado_por', 'es.nombre as estacion', 'co.nombre as consumidor', 'co.oficina as consumidor_of','cc.created_at as fecha'
                 );
          $datos = json_decode( json_encode($query->get()), true);
          Excel::create('CuentaDetalle', function($excel) use($datos){
                $excel->sheet('Excelsheet', function($sheet) use($datos){
                    $sheet->with($datos, null, 'A1', true);
                    $sheet->setOrientation('landscape');
                });
            })->download('xlsx');
        }
        $perpage = $this->getPaginacion(request('paginacion'));

        $lineas = $query->paginate($perpage);

        $lineas->appends(['paginacion' => $perpage]);
        $lineas->appends(['buscarpor' => $searchby]);
        $lineas->appends(['buscar' => $search]);
        $lineas->appends(['fecha_hasta' => request('fecha_hasta')]);
        $lineas->appends(['fecha_desde' => request('fecha_desde')]);


        return view('cuentacorriente.detalle',['lineas' => $lineas, 'cuenta' => $cuenta , 'id' => $id]);
    }
}
