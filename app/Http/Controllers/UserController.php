<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function login(Request $request)
    { 
      dd($request);
      if (Session::get('token') != ''){
        return view ("admin.dashboard");
      }
        $url= env("URL_SERVER_API", "http://127.0.0.1");
        $response=Http::post($url."login", [
            "email"=>$request->email,
            "password"=>$request->password,
        ]);
        //dd($response->status());
        if($response->status()== 404)
      {
        return view ("auth.login",compact("response"));
        
      }elseif($response->status()== 200){
        Session::put('token',$response['msg']);
        cookie('token',$response['msg']);
        return view ("admin.dashboard");

      }elseif($response->status()== 401){

        return view ("auth.login", compact("response"));

      }
        $data= $response->json();
        
    }

}
