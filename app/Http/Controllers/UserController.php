<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\PdfMailable;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //Recibimos del json enviado en el ajax los datos del formulario
        $str_base64 = $request->input('dataurl_canvas');
        //contenido de la imagen en base64, extensión y archivo
        $base64File = base64_decode(explode(',',$str_base64)[1]);
        $extension = explode('/',mime_content_type($str_base64))[1];
        $name_path = sprintf('%s.%s',uniqid('user_'),$extension);

        $data = [
            'name'      => $request->input('name'),
            'email'     => $request->input('email'),
            'filename'  => $name_path
        ];

        Storage::disk('user_signs')->put($name_path,$base64File);

        //convertimos la vista de blade a HTML y le enviamos los datos
        $html = View::make('user.pdf',compact('data'))->render();

        //Generamos el PDF y lo enviamos por correo
        $pdf = Pdf::loadHTML($html);
        //Mail::to('martinezpvivi@gmail.com')->send(new PdfMailable($pdf));
        //retornamos una respuesta a la llamada
        $response = ['error'=>false, 'message' => 'La información se ha enviado con éxito.'];
        return new Response(json_encode($response),200);
    }

    /**
     * Get image user sign
     */

    public function getUserSign($filename)
    {
        //obtener la imagen de la firma del disco storage
        $file = Storage::disk('user_signs')->get($filename);
        Storage::setVisibility($filename, 'public');
        return new Response($file,200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
