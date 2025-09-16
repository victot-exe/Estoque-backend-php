<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEstoqueRequest;
use App\Models\Estoque;
use App\Services\Contracts\EstoqueServiceInterface;

class EstoqueController extends Controller
{
    public function __construct(private EstoqueServiceInterface $service) {}
    public function index()
    {
        return Estoque::latest()->paginate(10);
    }

    public function store(StoreEstoqueRequest $request)
    {
        $result = $this->service->create($request->validated());
        return response()->json($result, 201);
    }

    public function show(Estoque $estoque)
    {
        return response()->json($estoque, 200);
    }

    public function update(StoreEstoqueRequest $request, Estoque $estoque)
    {
        $result = $this->service->update($estoque, $request->validated());
        return response()->json($result, 200);
    }

    public function destroy(Estoque $estoque)
    {
        $this->service->delete($estoque);
        return response()->noContent();
    }

    public function showGroupByValidade(){
        $result = $this->service->getAllEstoqueGroupByValidadeAndProduto();

        return response()->json($result, 200);
    }
}
