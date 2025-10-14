<?php
namespace App\Services\Contracts;
use App\Http\Requests\VendaRequest;
use App\Models\Evento;

interface EventoServiceInterface{
    function vender(array $data);
    public function getEventosAgrupados();
    public function create(array $evento);
}