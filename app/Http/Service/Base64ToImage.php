<?php

namespace App\Http\Service;

use Illuminate\Support\Facades\Storage;

class Base64ToImage{

    public static function base64File($data_url)
    {
        //contenido de la imagen en base64, extensión y archivo
        $base64File = base64_decode(explode(',',$data_url)[1]);
        $extension = explode('/',mime_content_type($data_url))[1];
        $name_path = sprintf('%s.%s',uniqid('user_'),$extension);
        //guardamos la imagen en disco
        Storage::disk('user_signs')->put($name_path,$base64File);
        //retornamos el nombre del archivo
        return $name_path;
    }
}
