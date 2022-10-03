<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\UserObserver;
use App\Adapters\APIAdapters\WebAPI;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Contracts\IUserRepository', 'App\Repositories\UserRepository');
        $this->app->bind('WebAPI', 'App\Adapters\APIAdapters\WebAPI');
        $this->app->bind('App\Adapters\APIAdapters\WebAPI', function() {
            $cToken = new Client();
            $webApiAddress = 'https://jsonplaceholder.typicode.com/'; 
            $client = new Client([
                'base_uri' => $webApiAddress,
                'headers' => ['Accept' => 'application/json'],
                'timeout' => 7200,
            ]);

            return (new WebAPI($client));                
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
    }
}
