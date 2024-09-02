<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as DB;
use Maatwebsite\Excel\Facades\Excel;

class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if (request('por_estaciones')){
        $this->reportePorEstacion();
      }

      return view('reportes.index');
    }

    public function porExpendedor()
    {
      if (request('por_estaciones')){
        $this->reportePorEstacion();
      }
      return view('expendedor.reportes');
    }

    public function reportePorEstacion()
    {

      $data = request()->validate([
        'fecha_desde' => 'required|date',
        'estacion_id' => 'required',
      ], [
        'estacion_id.required' => 'El campo Estación es obligatorio'
      ]);
      $query = DB::table(DB::raw('cuenta_corriente cc'))
                   ->leftJoin(DB::raw('usuarios as u'), 'cc.usuario_id','=','u.id') // cuenta
                   ->leftJoin(DB::raw('usuarios as ur'), 'cc.audi_usuario_id','=','ur.id')
                   ->leftJoin(DB::raw('estaciones as es'), 'cc.estacion_id','=','es.id')
                   ->leftJoin(DB::raw('usuarios as co'), 'cc.usuario_id_consumidor','=','co.id')
               ->select('u.nombre as cuenta', 'cc.linea', 'cc.tipo_movimiento', 'cc.saldo',
                        'cc.monto','cc.created_at as momento','cc.comentarios',
                        'ur.nombre as expendedor', 'es.nombre as estacion', 'es.empresa',
                        'co.nombre as consumidor', 'cc.created_at as fecha'
                        )
               ->where('cc.estacion_id',request('estacion_id'))
               ->orderby('cc.created_at','desc');

      if (request('fecha_desde')){
        $query = $query->where(DB::raw('DATE(cc.created_at)'),'>=',request('fecha_desde'));
      }
      if (request('fecha_hasta')){
        $query = $query->where(DB::raw('DATE(cc.created_at)'),'<=',request('fecha_hasta'));
      }

      if (request('excel')){
        $total = $query->sum('cc.monto');
        $linea_total=   [
            "cuenta" => "",
            "linea" => "",
            "tipo_movimiento" => "",
            "saldo" => "Total:",
            "monto" => $total,
            "momento" => "",
            "comentarios" => "",
            "expendedor" => "",
            "estacion" => "",
            "empresa" => "",
            "consumidor" => "",
            "fecha" => ""
          ];
        $datos = json_decode( json_encode($query->get()), true);
        $datos[] = $linea_total;
        Excel::create('Consumo', function($excel) use($datos){
              $excel->sheet('Detalle', function($sheet) use($datos){
                  $sheet->with($datos, null, 'A1', true);
                  $sheet->setOrientation('landscape');
              });
          })->download('xlsx');
      }
    }
}
