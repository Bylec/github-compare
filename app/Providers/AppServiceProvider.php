<?php

namespace App\Providers;

use App\Services\GithubService;
use App\Services\GithubServiceInterface;
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
        $this->app->bind(GithubServiceInterface::class, GithubService::class);
    }
}
