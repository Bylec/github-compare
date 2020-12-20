<?php

namespace App\HttpService;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Collection;

class GithubHttpClient
{
    protected $guzzleClient;

    /**
     * GithubHttpClient constructor.
     *
     * @param Client $guzzleClient
     */
    public function __construct(Client $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * Fetches basic repository data.
     *
     * @param string $owner
     * @param string $repo
     *
     * @return Collection
     */
    public function fetchRepositoryData(string $owner, string $repo): Collection
    {
        $request = new Request("GET", "repos/$owner/$repo");

        return collect($this->call($request));
    }

    /**
     * Fetches data for repository release data.
     *
     * @param string $owner
     * @param string $repo
     *
     * @return Collection
     */
    public function fetchLatestRepositoryReleaseData(string $owner, string $repo): Collection
    {
        $request = new Request("GET",
            "repos/$owner/$repo/releases/latest"
        );

        return collect($this->call($request));
    }

    /**
     * Fetches data for repository merge request data.
     *
     * @param string $owner
     * @param string $repo
     *
     * @return Collection
     */
    public function fetchMergeRequestRepositoryData(string $owner, string $repo): Collection
    {
        $request = new Request("GET",
            "repos/$owner/$repo/pulls",
            [
                "query" => "per_page=100&state=all"
            ]
        );

        return collect($this->call($request));
    }

    /**
     * Triggers GuzzleService call.
     *
     * @param Request $request
     *
     * @return array
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function call(Request $request): array
    {
        return json_decode($this->guzzleClient
            ->send($request)
            ->getBody()
            ->getContents(), true);
    }
}
