<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('page.clients.index');
    }

    public function getClients()
    {
        $clients = Client::all(); // Recupera todos los clientes
        return response()->json($clients); // Retorna los datos en formato JSON

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
        try {
            // Validar los datos recibidos
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'dni' => 'required|string|max:8|unique:clients,dni',
                'ruc' => 'nullable|string|max:11|unique:clients,ruc',
                'phone' => 'nullable|string|max:9',
                'address' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
            ], [
                'dni.unique' => 'El DNI ingresado ya está registrado.',
                'ruc.unique' => 'El RUC ingresado ya está registrado.',
            ]);

            // Crear el nuevo cliente
            $client = Client::create($validatedData);

            return response()->json($client, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
            ], 422); // Código 422 para errores de validación
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error inesperado.',
                'error' => $e->getMessage()
            ], 500); // Código 500 para errores generales
        }
    }




    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        return response()->json($client);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Valida los datos que vienen del formulario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'dni' => 'required|string|max:20|unique:clients,dni,' . $id, // Asegura que el DNI sea único excepto para el cliente actual
            'ruc' => 'nullable|string|max:20|unique:clients,ruc,' . $id, // Asegura que el RUC sea único excepto para el cliente actual
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:clients,email,' . $id, // Email único excepto para el cliente actual
        ]);

        // Encuentra el cliente por ID
        $client = Client::find($id);

        // Si no encuentra el cliente, muestra un error
        if (!$client) {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        // Actualiza los valores del cliente con los datos validados
        $client->name = $validatedData['name'];
        $client->dni = $validatedData['dni'];
        $client->ruc = $validatedData['ruc'] ?? $client->ruc;
        $client->phone = $validatedData['phone'] ?? $client->phone;
        $client->address = $validatedData['address'] ?? $client->address;
        $client->email = $validatedData['email'] ?? $client->email;

        // Guarda los cambios
        $client->save();

        // Devuelve una respuesta con el cliente actualizado
        return response()->json($client);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $client = Client::find($id);
        if (!$client) {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        $client->delete();
        return response()->json(['message' => 'Cliente eliminado exitosamente']);
    }
}
