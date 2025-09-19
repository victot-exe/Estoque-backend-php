<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProdutoRequest;
use App\Http\Requests\StoreProdutoUpdate;
use App\Models\Produto;
use App\Services\Contracts\ProdutoServiceInterface;

class ProdutoController extends Controller
{
    public function __construct(private ProdutoServiceInterface $service){}
    
    public function index()
    {
        return Produto::latest()->paginate(10);
    }

    public function store(StoreProdutoRequest $request)
    {
        $produto = $this->service->create($request->validated());

        return response()->json($produto, 201);
    }

    public function show(Produto $produto)
    {
        return $produto;
    }

    public function update(StoreProdutoUpdate $request, Produto $produto)
    {
        $result = $this->service->update($produto, $request->validated());
        return response()->json($result, 200);
    }

    public function destroy(Produto $produto)
    {
        $this->service->delete($produto);
        return response()->noContent();
    }

    public function showAllAgruped(){
        $result = $this->service->showAllInformations();
        return response()->json($result, 200);
    }
}
