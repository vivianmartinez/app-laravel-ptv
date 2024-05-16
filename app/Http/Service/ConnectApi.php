<?php

namespace App\Http\Service;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Http;

class ConnectApi{

    public static function retrieveUser($endpoint)
    {
        //usamos la url fija de la llamada a la API (variable de entorno) y recuperar el usuario
        $url = env('URL_API');

        //hacemos la llamada y si falla nos redirige a la página de login
        try{
            $response = Http::get($url.$endpoint);
            if($response->ok()){
                $data_xml = simplexml_load_string($response->body());
                $json = json_encode($data_xml);
                $data = json_decode($json,true)['Registro']['@attributes'];
                return $data;
            }
        }catch(HttpResponseException $e){
            return null;
        }
    }
}
