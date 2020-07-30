<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Blade::include('components.table', 'table');
        Blade::include('components.card', 'card');
        Blade::include('components.form', 'form');
        Blade::include('components.tabs', 'tabs');
        Blade::include('components.graph', 'graph');
        Blade::include('components.price_graph', 'price_graph');
        Blade::include('components.quantity_graph', 'quantity_graph');
    }
}
