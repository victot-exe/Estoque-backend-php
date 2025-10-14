<?php

namespace App\Http\Controllers;

use App\Http\Requests\VendaRequest;
use App\Http\Requests\VendaUnitariaRequest;
use App\Models\Evento;
use App\Services\Contracts\EventoServiceInterface;
use Illuminate\Http\JsonResponse;

class EventoController extends Controller
{
    protected EventoServiceInterface $service;

    public function __construct(EventoServiceInterface $service)
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

    public function venderUnitario (VendaUnitariaRequest $request){
        return $this->service->create($request->validated());
    }

    public function destroy(Evento $evento){
        $deleted = $evento->delete();

        try{
            if(!$deleted){
                throw new \Exception('A exclusão do evento foi impedida pela lógica interna.');
            }
            return response()->noContent();
        }catch(\Exception $e){
            return response()->json([
                'error' => 'Ocorreu um erro interno ao tentar excluir o evento.'
            ], 500);
        }
    }
}