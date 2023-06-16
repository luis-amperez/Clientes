<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth:sanctum');
  }

    public function clientes(Request $request){

      $response["status"] = 1;
      $response["msg"] = '';

    
     

      if (Auth::User()->can('listarClientes')){
          $clientes = Cliente::all();
          $response["status"] = 200;
          $response["msg"] = 'Exito';
          $response['data'] = $clientes;
          return response()->json($response, 200);

      }else{
          $response["msg"] = 'Permiso denegado, comuniquese con su adminstrador';
          return response()->json($response, 401);
      }
      //$users = Hash::make('Admin1234');


      return response()->json($clientes, 200);
      //return response(["mensaje"=>'Ok'], $users,Response::HTTP_OK);
  }

  public function crearClientes(Request $request){

    $response["status"] = 1;
    $response["msg"] = '';
    $nombre_cliente = $request->nombre;
    $correo_cliente = $request->correo;
if(Auth::User()->can('listarClientes')){
    DB::connection('mysql')->beginTransaction();
    try {
       Cliente::create(['nombre' => $nombre_cliente, 'correo' => $correo_cliente]);
        DB::connection('mysql')->commit();
        $response["status"]  = 200;
        $response["msg"] = 'Cliente creado con exito';
         $clientes = Cliente::all();
         $response['data'] = $clientes;
        return response()->json($response, 200);
    } catch (\Throwable $th) {
        DB::connection('mysql')->rollBack();
        $response["status"]  = 404;
        $response["msg"] = $th->getMessage();
        return response()->json($response, 404);
    }

}else{
  $response["status"]  = 404;
  $response["msg"] = "permiso denegado";
  return response()->json($response, 404);
}

}

public function eliminarClientes($id){
    //$response = new StdClass();
    $response["status"] = 1;
    $response["msg"] = '';
    $clientes = Cliente::where('id',$id)->first();

if(Auth::User()->can('listarClientes')){
    DB::connection('mysql')->beginTransaction();
    try {
        if (empty($clientes)){

            $response["status"]  = 200;
            $response["msg"] = 'Cliente no existe';
             $clientes = Cliente::all();
             $response['data'] = $clientes;
            return response()->json($response, 200);
        }else{
            $clientes->delete();
            DB::connection('mysql')->commit();
            $response["status"]  = 200;
            $response["msg"] = 'Cliente eliminado exitosamente';
             $clientes = Cliente::all();
             $response['data'] = $clientes;
            return response()->json($response, 200);
        }
    } catch (\Throwable $th) {
        DB::connection('mysql')->rollBack();
        $response["status"]  = 404;
        $response["msg"] = $th->getMessage();
        return response()->json($response, 404);
    }

}else{
  $response["status"]  = 404;
  $response["msg"] = "permiso denegado";
  return response()->json($response, 404);
}
return response()->json($response); 
}



}