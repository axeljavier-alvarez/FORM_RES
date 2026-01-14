<?php

namespace App\Http\Controllers\Interno;

use App\Http\Controllers\Controller;
use App\Models\Solicitud;
use Illuminate\Http\Request;

class VisitaCampoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return view('interno.campo.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Solicitud $solicitud)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Solicitud $solicitud)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Solicitud $solicitud)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Solicitud $solicitud)
    {
        //
    }

    public function upload(Request $request)
{
    $request->validate([
        'upload' => 'required|image|max:2048'
    ]);

    $file = $request->file('upload');
    $filename = time() . '_' . $file->getClientOriginalName();
    $path = $file->storeAs('public/uploads', $filename);

    return response()->json([
        'url' => Storage::url($path)
    ]);
}


}
