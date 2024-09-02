<?php

namespace App\Http\Controllers;

use App\Repositories\Movimiento;
use App\User;
use Illuminate\Support\Facades\DB as DB;

class ConsumoController extends Controller
{
    public function __construct(Movimiento $movimiento)
    {
        $this->movimiento = $movimiento;
    }

    public function minutosRestantesProximoConsumo($consumidor_id)
    {
      $minutos = 0;
      $tiempo_bloqueo = env('BLOQUEO_CONSUMO_TIEMPO', '00:06');
      $t= \DB::table('cuenta_corriente')
      ->where([
                ['usuario_id_consumidor','=', $consumidor_id],
                ['created_at','>',\DB::raw('SUBTIME(now(), \''.$tiempo_bloqueo.'\')')]
              ])
      ->select(\DB::raw('TIMESTAMPDIFF(MINUTE,  SUBTIME(now(), \''. $tiempo_bloqueo .'\'), created_at) as minutos'))
      ->first();

      $minutos = isset($t) ? $t->minutos: $minutos;
      return $minutos;
    }
    public function ultimosConsumos($consumidor_id)
    {
        return \DB::table('cuenta_corriente')
                ->where([
                        ['usuario_id_consumidor','=', $consumidor_id],
                        ['cuenta_corriente.estacion_id','=', \Auth::user()->estacion_id],
                ])
                ->leftJoin(\DB::raw('usuarios as co'), 'usuario_id_consumidor','=','co.id')
                ->leftJoin(\DB::raw('usuarios as ex'), 'audi_usuario_id','=','ex.id')
                ->select('cuenta_corriente.monto', 'cuenta_corriente.id as consumo_id', 'cuenta_id_anulacion',
                    'cuenta_corriente.comentarios',
                    'ex.nombre as expendedor',
                    'co.nombre as consumidor', 'cuenta_corriente.created_at as fecha','tipo_movimiento'
                )->orderBy('cuenta_corriente.id','desc')
                ->limit(5)
                ->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( request('dni')){
            // validar DNI
          $data = request()->validate([
            'dni' => 'required',
          ]);

          $usuario =  User::where('dni', request('dni'))->first();
          if($usuario){
            return redirect('consumo/ingresar/'.$usuario->id);
          }
        }
        return view('consumo.index');
    }

    public function ingresar($id){
      $usuario =  User::where('id',$id)->first();

      $consumos = $this->ultimosConsumos($id);
      $cuenta_principal_id =  User::where('id',$id)->value('cuenta_principal_id');
      $cuenta_principal = $this->movimiento->ObtenerCuentaSaldo($cuenta_principal_id);
      $saldo = isset($cuenta_principal) ? $cuenta_principal->saldo: 0;

      return view('consumo.ingresar',compact('usuario','consumos','saldo'));
    }

    public function validar($id){
      $monto = request('monto');

      $data = request()->validate([
        'monto' => 'required|min:1'
      ]);

      $cuenta_principal_id =  User::where('id',$id)->value('cuenta_principal_id');


      $cuenta_principal = $this->movimiento->ObtenerCuentaSaldo($cuenta_principal_id);
      $saldo =  isset($cuenta_principal) ? $cuenta_principal->saldo: 0;

      if (( $saldo - $monto) < 0){
          return back()->withErrors(['saldo'=> 'Saldo Insuficiente:  ($'. $saldo.')']);
      }

      if (( $tiempo =  $this->minutosRestantesProximoConsumo($id) ) > 0){
          return back()->withErrors(['bloqueo_consumo'=> 'Debe esperar:'. $tiempo.' minuto(s) antes de registrar un nuevo consumo']);
      }


      return redirect()->action(
        'ConsumoController@verificarusuario', ['id' => $id, 'monto' => $monto]
      );
    }

    public function verificarusuario($id,$monto)
    {
      return view('consumo.verificarusuario',compact(['id','monto']));
    }

    public function grabar($id,$monto)
    {
      $pin = request('pin');

      $consumidor = User::find($id);

      if (!\Hash::check($pin, $consumidor->password)) {
          return back()->withErrors(['pin' => 'PIN incorrecto']);
      }

      $cuenta_principal_id =  $consumidor->cuenta_principal_id;

      $cuenta_principal = $this->movimiento->ObtenerCuentaSaldo($cuenta_principal_id);

      $datos['saldo'] =  $cuenta_principal->saldo - abs($monto);

      \Validator::make($datos, [
          'saldo' => [
              'numeric',
              'min:0',
          ],
      ],
      [
        'saldo.min' => 'Saldo insuficiente:  ($'. $datos['saldo'].')'
      ])->validate();

      $estacion_id = \Auth::user()->estacion_id;
      $estacion = DB::table('estaciones')->where('id',$estacion_id)->value('nombre');

        // grabar Consumo
        //
      $this->movimiento->Consumir($cuenta_principal_id,$consumidor->id,$monto,$estacion_id,$consumidor->nombre,$estacion);

      $expendedor = \Auth::user()->nombre;
      $fecha = date("Y-m-d H:i:s");

      $consumidor = $consumidor->nombre;
      $datos = compact(['consumidor','monto','estacion','fecha','expendedor']);

      return redirect('consumo/registrado')->with('datos',$datos);

    }

    public function show()
    {
        if(empty(session('datos'))){
          return redirect('consumo');
        }
        $datos = session('datos');
        $consumidor = $datos['consumidor'];
        $monto = $datos['monto'];
        $estacion = $datos['estacion'];
        $fecha = $datos['fecha'];
        $expendedor = $datos['expendedor'];
        return view('consumo.grabar',compact(['consumidor','monto','estacion','fecha','expendedor']));
    }

    public function destroy($movimiento_id)
    {
        $this->movimiento->AnularConsumo($movimiento_id);
        return redirect()->back();
    }


}
