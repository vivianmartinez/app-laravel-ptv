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

        $data = ConnectApi::retrieveUser($endpoint);

        //enviamos a la vista del formulario los datos que vienen de la llamada
        if($data !== null){
            return view('user.form', Array(
                'name' => trim($data['Nombre']),
                'email'=> trim($data['Email'])
            ));
        }

        //si ocurre un error con los datos ingresados probablemente estén errados
        return back()->withErrors([
            'dni' => 'The provided credentials don\'t match our records.',
        ])->onlyInput('user');
    }

}
