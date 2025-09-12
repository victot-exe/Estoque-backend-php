<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProdutoRequest;
use App\Models\Produto;
use App\Services\Contracts\ProdutoServiceInterface;

class ProdutoController extends Controller
{
    public function __construct(private ProdutoServiceInterface $service){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Produto::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProdutoRequest $request)
    {
        $produto = $this->service->create($request->validated());

        return response()->json($produto, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Produto $produto)
    {
        return $produto;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProdutoRequest $request, Produto $produto)
    {
        $result = $this->service->update($produto, $request->validated());
        return response()->json($result, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produto $produto)
    {
        $this->service->delete($produto);
        return response()->noContent();
    }
}
