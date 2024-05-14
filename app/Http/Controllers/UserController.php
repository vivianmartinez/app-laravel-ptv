<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        //
        $data = [
            'name'  => $request->input('name'),
            'email' => $request->input('email'),
        ];

       // Mail::to('martinezpvivi@gmail.com')->send(new DataMailable($data));

        return view('user.form')->with('status','mail-success') ;
    }

    /**
     * Generate PDF and send by email
     */

    public function generateReportPdf(Request $request)
    {
        $data = [
            'name'  => $request->input('name'),
            'email' => $request->input('email'),
        ];

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
