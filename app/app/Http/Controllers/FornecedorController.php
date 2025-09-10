<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFornecedorRequest;
use App\Models\Fornecedor;
use App\Services\Contracts\FornecedorServiceInterface;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    public function __construct(private FornecedorServiceInterface $service){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Fornecedor::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFornecedorRequest $request)
    {
        $fornecedor = $this->service->create($request->validated());

        return response()->json($fornecedor, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Fornecedor $fornecedor)
    {
        return "Nao implementado ainda";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fornecedor $fornecedor)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fornecedor $fornecedor)
    {
        return $this->service->delete($fornecedor);
    }
}
