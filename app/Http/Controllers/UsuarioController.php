<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB as DB;

class UsuarioController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      $orderby = $this->getOrden(request('ordenarpor'));
      list($searchby,$search)= $this->getBuscar(request('buscarpor'),request('buscar'));

      $rol =  $this->getRol(request('rol'));

      $query = DB::table(DB::raw('usuarios as u'))
                   ->leftJoin(DB::raw('usuarios as cp'), 'cp.id','=','u.cuenta_principal_id')
                   ->orderby('u.'.$orderby,'ASC')
                   ->select ('u.dni as dni','u.nombre','u.rol','u.created_at','u.email','u.id','cp.nombre as cuenta','u.oficina');

      if ($searchby){
        $query = $query->where($searchby,'like','%'.$search.'%');
      }

      if($rol){
        $query = $query->where('u.rol',$rol);
      }

      if (request('excel')){
        $query = $query->select('u.dni as DNI','u.nombre as Nombre','u.rol','u.created_at as Registro','u.email as Correo-e','cp.nombre as cuenta','u.oficina');
        $datos = json_decode( json_encode($query->get()), true);
        Excel::create('Usuarios', function($excel) use($datos){
              $excel->sheet('Excelsheet', function($sheet) use($datos){
                  $sheet->with($datos, null, 'A1', true);
                  $sheet->setOrientation('landscape');
              });
          })->download('xlsx');
      }

      $perpage = $this->getPaginacion(request('paginacion'));

      $usuarios = $query->paginate($perpage);

      $usuarios->appends(['ordenarpor' => $orderby]);
      $usuarios->appends(['paginacion' => $perpage]);
      $usuarios->appends(['buscarpor' => $searchby]);
      $usuarios->appends(['buscar' => $search]);
      $usuarios->appends(['rol' => $rol]);

      return view('usuarios.index',compact('usuarios'));
  }

  public function getRol($rol)
  {
    if ($rol =='administrador'){
      return 'administrador';
    }
    if ($rol =='usuario'){
      return 'usuario';
    }
    if ($rol =='expendedor'){
      return 'expendedor';
    }
    if ($rol =='cuenta_principal'){
      return 'cuenta_principal';
    }
    if ($rol =='visor_cuentas'){
      return 'visor_cuentas';
    }
    return '';
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
        return ['u.dni',$search];
      }
      if ($searchby =='email'){
        return ['u.email',$search];
      }
      if ($searchby =='nombre'){
        return ['u.nombre',$search];
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
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(User $usuario)
  {
      return view('usuarios.create', ['usuario' => $usuario]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $data = request()->validate([
      'dni' => 'required|unique:usuarios,dni',
      'email' => 'nullable|unique:usuarios,email',
      'password' => 'required|confirmed',
      'nombre' => 'required',
      'rol' => 'required',
      'es_cuenta_principal' => 'nullable',
      'cuenta_principal_id' => 'nullable',
      'comentarios' => 'nullable',
      'estacion_id' => 'nullable',
      'oficina' => 'nullable'
    ], [
      'dni.required' => 'El campo DNI es obligatorio'
    ]);

    if ($data['rol'] == 'expendedor'){
      $data2 = request()->validate([
        'estacion_id' => 'required'
      ], [
        'estacion_id.required' => 'El expendedor debe tener una Estación asignada'
      ]);
    }

    if (!empty($data['es_cuenta_principal'])){
      $data['rol'] = 'cuenta_principal';
    }
    $data['password']= bcrypt($data['password']);
    User::create($data);
    return redirect()->route('usuarios.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(user $usuario)
  {
      return view('usuarios.show', ['usuario' => $usuario]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit(User $usuario)
   {
       return view('usuarios.edit', ['usuario' => $usuario]);
   }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, User $usuario)
  {
      $data = request()->validate([
              'dni' => 'required',
              'email' => 'nullable',
              'password' => 'nullable',
              'nombre' => 'required',
              'rol' => 'required',
              'es_cuenta_principal' => 'nullable',
              'cuenta_principal_id' => 'nullable',
              'comentarios' => 'nullable',
              'estacion_id' => 'nullable',
              'oficina' => 'nullable'
      ]);
      if ($data['rol'] == 'expendedor'){
        $data2 = request()->validate([
          'estacion_id' => 'required'
        ], [
          'estacion_id.required' => 'El expendedor debe tener una Estación asignada'
        ]);
      }
      if ($data['password'] != null) {
          $data['password'] = bcrypt($data['password']);
      } else {
          unset($data['password']);
      }
      if (!empty($data['es_cuenta_principal'])){
        $data['rol'] = 'cuenta_principal';
      }
      $usuario->update($data);
      return redirect()->route('usuarios.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
     try {
       User::destroy($id);
       return redirect()->route('usuarios.index')->with('delete_ok','Registro eliminado');
    }catch (\Illuminate\Database\QueryException $e){
       return redirect()->route('usuarios.index')->with('delete_fail','No se pudo eliminar la cuenta');
    }
  }

  public function cambiarclave()
  {
      return view('auth.change');
  }
  public function grabarcambiarclave()
  {
      $user = \Auth::user();
      if (!\Hash::check(request('oldpassword'), $user->password)) {
          return back()->withErrors(['oldpassword' => 'Contraseña Incorrecta']);
      }
      $data = request()->validate([
              'password' => 'required|confirmed',
      ]);
      $data['password']= bcrypt($data['password']);
      $user->update($data);
      return redirect('/');
  }
}
