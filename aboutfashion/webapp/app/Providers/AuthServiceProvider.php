<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
      'App\Models\Card' => 'App\Policies\CardPolicy',
      'App\Models\Item' => 'App\Policies\ItemPolicy',
      'App\Models\Detail' => 'App\Policies\DetailPolicy',
      'App\Models\Admin' => 'App\Policies\AdminPolicy',
      'App\Models\Product' => 'App\Policies\ProductPolicy',
      'App\Models\Review' => 'App\Policies\ReviewPolicy',
      'App\Models\Promotion' => 'App\Policies\PromotionPolicy',
      'App\Models\Order' => 'App\Policies\OrderPolicy',
      'App\Models\Category' => 'App\Policies\CategoryPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}