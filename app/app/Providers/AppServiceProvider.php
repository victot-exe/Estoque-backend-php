<?php

namespace App\Providers;

use App\Services\Contracts\EstoqueServiceInterface;
use App\Services\Contracts\FornecedorServiceInterface;
use App\Services\Contracts\ProdutoServiceInterface;
use App\Services\EstoqueService;
use App\Services\FornecedorService;
use App\Services\ProdutoService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FornecedorServiceInterface::class, FornecedorService::class);
        $this->app->bind(ProdutoServiceInterface::class, ProdutoService::class);
        $this->app->bind(EstoqueServiceInterface::class, EstoqueService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
