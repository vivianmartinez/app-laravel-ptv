<?php

namespace App\Http\Controllers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Process login user
     */

     public function login(Request $request){
        //validar datos requeridos
        $request->validate([
            'user' => ['required'],
            'dni' => ['required'],
        ]);

        //usamos la url fija de la llamada a la API
        $url = env('URL_API');
        //generamos el endpoint con los datos recibidos
        $format_endpoint = '/%s/%s';
        $endpoint = sprintf($format_endpoint,$request->input('user'),$request->input('dni'));
        //hacemos la llamada y si falla nos redirige a la página de login
        try{
            $response = Http::get($url.$endpoint);
            if($response->ok()){
                $data_xml = simplexml_load_string($response->body());
                $json = json_encode($data_xml);
                $data = json_decode($json,true)['Registro']['@attributes'];
                //enviamos a la vista del formulario los datos que vienen de la llamada
                return view('user.form', Array(
                    'name' => trim($data['Nombre']),
                    'email'=> trim($data['Email'])
                ));
            }
        }catch(HttpResponseException $e){
            return redirect('/');
        }
        //si ocurre un error con los datos ingresados probablemente estén errados
        return back()->withErrors([
            'dni' => 'The provided credentials don\'t match our records.',
        ])->onlyInput('user');
    }
}
