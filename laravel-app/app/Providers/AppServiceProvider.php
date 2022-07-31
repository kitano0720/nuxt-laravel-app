<?php

namespace App\Providers;

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
        // リポジトリ
        $this->app->bind(
            \App\Repositories\Interface\SampleRepositoryInterface::class,
            \App\Repositories\Implements\SampleRepository::class
        );

        // サービス
        $this->app->bind(
            \App\Services\Interface\SampleServiceInterface::class,
            function ($app) {
                return new \App\Services\Implements\SampleService(
                    $app->make(\App\Repositories\Interface\SampleRepositoryInterface::class)
                );
            },
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
