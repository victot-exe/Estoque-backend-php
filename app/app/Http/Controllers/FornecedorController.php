<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFornecedorRequest;
use App\Models\Fornecedor;
use App\Services\Contracts\FornecedorServiceInterface;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    public function __construct(private FornecedorServiceInterface $service){}

    public function index()
    {
        return Fornecedor::latest()->paginate(10);
    }

    public function store(StoreFornecedorRequest $request)
    {
        $fornecedor = $this->service->create($request->validated());

        return response()->json($fornecedor, 201);
    }

    public function show(Fornecedor $fornecedor)
    {
        return response()->json($fornecedor, 200);
    }

    public function update(StoreFornecedorRequest $request, Fornecedor $fornecedor)
    {
            $result = $this->service->update($fornecedor, $request->validated());
            return response()->json($result, 200);
    }

    public function destroy(Fornecedor $fornecedor)
    {
        $this->service->delete($fornecedor);
        return response()->noContent();
    }
}
