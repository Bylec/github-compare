<?php

namespace App\Providers;

use App\HttpService\GithubHttpClient;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class GithubServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->configure('github');

        $this->app->bind(
            GithubHttpClient::class,
            function() {
                $guzzleClient = new Client([
                    'base_uri' => config('github.url')
                ]);
                return new GithubHttpClient($guzzleClient);
            }
        );
    }
}
