<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consumos = $this->ultimosConsumos(\Auth::user()->id);
        return view('home',compact('consumos'));
    }

    public function ultimosConsumos($expendedor_id)
    {
        return \DB::table('cuenta_corriente')
            ->where('audi_usuario_id','=', $expendedor_id )
            ->leftJoin(\DB::raw('usuarios as co'), 'usuario_id_consumidor','=','co.id')
            ->leftJoin(\DB::raw('usuarios as ex'), 'audi_usuario_id','=','ex.id')
            ->select('cuenta_corriente.monto','cuenta_corriente.id as consumo_id',
                'ex.nombre as expendedor',
                'co.nombre as consumidor', 'cuenta_corriente.created_at as fecha'
            )
            ->get();
    }
}
