<?php

namespace App\Providers;

use App\Exceptions\Handler  as AppExceptionHandler;;
use App\Services\Contracts\EstoqueServiceInterface;
use App\Services\Contracts\FornecedorServiceInterface;
use App\Services\Contracts\ProdutoServiceInterface;
use App\Services\Contracts\EventoServiceInterface;
use App\Services\EstoqueService;
use App\Services\EventoService;
use App\Services\FornecedorService;
use App\Services\ProdutoService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(FornecedorServiceInterface::class, FornecedorService::class);
        $this->app->bind(ProdutoServiceInterface::class, ProdutoService::class);
        $this->app->bind(EstoqueServiceInterface::class, EstoqueService::class);
        $this->app->bind(EventoServiceInterface::class, EventoService::class);
    }

    public function boot(): void
    {
        //
    }
}
