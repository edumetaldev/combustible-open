<?php

namespace App\Http\Controllers;

use App\Exports\EstacionExport;
use App\Models\Estacion;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
class EstacionController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$query = Estacion::query();
		$orderby = $this->getOrden(request('ordenarpor'));

		$query->orderby($orderby, 'ASC');

		if (request('excel')) {
			return Excel::download(new EstacionExport(), 'Estaciones.xlsx',\Maatwebsite\Excel\Excel::XLSX);
		}

		$perpage = $this->getPaginacion(request('paginacion'));
		$estaciones = $query->paginate($perpage);

		$estaciones->appends(['ordenarpor' => $orderby]);
		$estaciones->appends(['paginacion' => $perpage]);

		return view('estaciones.index', ['estaciones' => $estaciones]);
	}

	public function getPaginacion($perpage)
	{
		if ($perpage > 0) {
			return $perpage;
		}
		return 10;
	}

	public function getOrden($orderby)
	{
		if ($orderby == 'empresa') {
			return 'empresa';
		}
		if ($orderby == 'localidad') {
			return 'localidad';
		}
		if ($orderby == 'nombre') {
			return 'nombre';
		}

		if ($orderby == 'created_at') {
			return 'created_at';
		}

		return 'id';
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Estacion $estacion)
	{
		return view('estaciones.create', compact('estacion'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		Estacion::create($request->all());
		return redirect()->route('estaciones.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Estacion  $estacion
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$estacion = Estacion::Find($id);
		return view('estaciones.show', compact('estacion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Estacion  $estacion
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$estacion = Estacion::Find($id);
		return view('estaciones.edit', compact('estacion'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Estacion  $estacion
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$estacion = Estacion::Find($id);
		$estacion->update($request->all());
		return redirect()->route('estaciones.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Estacion  $estacion
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		try {
			Estacion::destroy($id);
			return redirect()->route('estaciones.index')->with('delete_ok', 'Registro eliminado');
		} catch (\Illuminate\Database\QueryException $e) {
			return redirect()->route('estaciones.index')->with('delete_fail', 'No se pudo eliminar la estación');
		}
	}
}
