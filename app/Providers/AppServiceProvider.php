<?php

namespace App\Providers;

use App\Models\Material;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\WorkOrder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::morphMap([
            'material' => Material::class,
            'product' => Product::class,
            'purchase_order' => PurchaseOrder::class,
            'work_order' => WorkOrder::class,
        ]);

        \Illuminate\Support\Facades\Route::redirect('/dashboard', '/sales');
    }
}
