<?php

namespace App\Providers;

use App\Repositories\AccountRepository;
use App\Repositories\Eloquent\AccountRepositoryEloquentEloquent;
use App\Repositories\Eloquent\LoyaltyPointsRepositoryEloquent;
use App\Repositories\LoyaltyPointsRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            AccountRepository::class,
            AccountRepositoryEloquentEloquent::class
        );

        $this->app->bind(
            LoyaltyPointsRepository::class,
            LoyaltyPointsRepositoryEloquent::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
