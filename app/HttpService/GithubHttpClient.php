<?php

namespace App\HttpService;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;

class GithubHttpClient
{
    protected $guzzleClient;

    public function __construct(Client $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    public function fetchRepositoryData(string $owner, string $repo)
    {
        $request = new Request("GET", "repos/$owner/$repo");


//        $request = $this->guzzleClient->get("repos/$owner/$repo");

        return $this->guzzleClient
            ->send($request)
            ->getBody()
            ->getContents();
    }
}
