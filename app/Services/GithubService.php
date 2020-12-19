<?php

namespace App\Services;

use App\HttpService\GithubHttpClient;

class GithubService implements GithubServiceInterface
{
    public function compareRepositories(array $repositories)
    {
        $githubClient = app(GithubHttpClient::class);

        dd($githubClient->fetchRepositoryData($repositories[0]['owner'], $repositories[0]['repo']));
    }
}
