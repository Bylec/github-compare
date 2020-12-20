<?php

namespace App\GithubCompare\DataSources;

use App\HttpService\GithubHttpClient;

abstract class AbstractDataSource implements DataSourceInterface
{
    /**
     * @var GithubHttpClient $githubClient api calls client
     */
    protected $githubClient;

    /**
     * AbstractDataSource constructor.
     */
    public function __construct()
    {
        $this->githubClient = app(GithubHttpClient::class);
    }
}
