<?php

namespace Modules\Ventas\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('ventas::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ventas::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cliente = Customer::create([
            'name' => $request->nombre,
            'phone' => $request->telefono,
            'address' => $request->direccion,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cliente creado correctamente.',
            'data' => $cliente,
        ]);
    }



    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('ventas::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('ventas::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}

    public function getClientes()
    {
        return response()->json(Customer::all());
    }
}
