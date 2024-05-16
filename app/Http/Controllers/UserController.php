<?php

namespace App\Http\Controllers;

use App\Http\Service\Base64ToImage;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\PdfMailable;
use App\Models\User;
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

        $name = ucwords(strtolower($request->input('name')));
        $email = $request->input('email');

        //validar no existente - se puede crear un validador personalizado
        $search_email = User::where('email', $email)->first();

        if($search_email != null){
            $response = ['error'=>false, 'message' => 'El usuario ya ha sido registrado'];
            return new Response(json_encode($response),200);
        }

        //guardamos el usuario
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $email, // le coloco el email de manera provisional
            'dni' => $request->input('dni'),
            'code_user' => $request->input('code_user')
        ]);

        //descomentar si queremos guardar el archivo de la firma usando el provider para subirlo y obtener el nombre
        //$name_path = Base64ToImage::base64File($request->input('dataurl_canvas'));

        //base64
        $name_path = $request->input('dataurl_canvas');

        $data = [
            'name'      => $name,
            'email'     => $email,
            'filename'  => $name_path
        ];

        //convertimos la vista de blade a HTML y le enviamos los datos
        $html = View::make('user.pdf',compact('data'))->render();

        //Generamos el PDF y lo enviamos por correo
        $pdf = Pdf::loadHTML($html);
        Mail::to($data['email'])->send(new PdfMailable($pdf,$data));

        //retornamos una respuesta a la llamada  Ajax
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
