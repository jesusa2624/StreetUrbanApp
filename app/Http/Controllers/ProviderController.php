<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('page.provider.index');
    }

    public function getProviders()
    {
        $providers = Provider::all();
        return response()->json($providers); 
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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'ruc' => 'required|string|max:11',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:9',
        ]);
        $provider = new Provider();
        $provider->name = $validatedData['name'];
        $provider->email = $validatedData['email'];
        $provider->ruc = $validatedData['ruc'];
        $provider->address = $validatedData['address'];
        $provider->phone = $validatedData['phone'];
        $provider->save();
        return response()->json(['message' => 'Proveedor registrado exitosamente'], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $provider = Provider::find($id);
        if(!$provider){
            return response()->json(['error' => 'Proveedor no encontrado'], 404);
        }
        return response()->json($provider);
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Provider $provider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'ruc' => 'required|string|max:11',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:9',
        ]);
        $provider = Provider::find($id);
        if(!$provider){
            return response()->json(['error' => 'Proveedor no encontrado'], 404);
        }
        $provider->name = $validatedData['name'];
        $provider->email = $validatedData['email'];
        $provider->ruc = $validatedData['ruc'];
        $provider->address = $validatedData['address'];
        $provider->phone = $validatedData['phone'];
        $provider->save();
        return response()->json(['message' => 'Proveedor actualizado exitosamente'], 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $provider = Provider::find($id);
        if(!$provider){
            return response()->json(['error' => 'Proveedor no encontrado'], 404);
        }
        $provider->delete();
        return response()->json(['message' => 'Proveedor eliminado exitosamente'], 200);
    }
}
