<?php

namespace App\Http\Controllers;

use App\Http\Service\ConnectApi;
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

     public function handle(Request $request){

        //validar datos requeridos
        $request->validate([
            'user' => ['required'],
            'dni' => ['required'],
        ]);
        //generamos el endpoint con los datos recibidos
        $format_endpoint = '/%s/%s';
        $endpoint = sprintf($format_endpoint,$request->input('user'),$request->input('dni'));
        //consultamos
        $data = ConnectApi::retrieveUser($endpoint);

        //enviamos a la vista del formulario los datos que vienen de la llamada
        if($data == 'timeout'){
            return redirect('/')->with('status','Ha ocurrido un error de conexión. Inténtelo más tarde.');
        }
        if($data !== null){
            return view('user.form', Array(
                'name' => trim($data['Nombre']),
                'email'=> trim($data['Email']),
                'code' => $request->input('user'),
                'dni'  => $request->input('dni')
            ));
        }

        //si ocurre un error con los datos ingresados probablemente estén errados
        return back()->withErrors([
            'dni' => 'Credenciales no validas.',
        ])->onlyInput('user');
    }
}
