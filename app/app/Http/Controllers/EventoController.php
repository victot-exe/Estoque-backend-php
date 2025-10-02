<?php

namespace App\Http\Controllers;

use App\Http\Requests\VendaRequest;
use App\Models\Evento;
use App\Services\EventoService;
use Illuminate\Http\JsonResponse;

class EventoController extends Controller
{
    protected EventoService $service;

    public function __construct(EventoService $service)
    {
        $this->service = $service;
    }

    public function index(){
        return Evento::latest()->paginate(20);
    }

    public function vender(VendaRequest $request): JsonResponse
    {
        try {
            $eventos = $this->service->vender($request->validated());

            return response()->json([
                'message' => 'Venda registrada com sucesso',
                'eventos' => $eventos,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }
    function vendasAgrupadas(){
        return $this->service->getEventosAgrupados();
    }
}

