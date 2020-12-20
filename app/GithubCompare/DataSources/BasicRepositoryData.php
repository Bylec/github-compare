<?php

namespace App\GithubCompare\DataSources;

use Illuminate\Support\Collection;

class BasicRepositoryData extends AbstractDataSource
{
    /**
     * Properties to return from API call.
     *
     * @var array
     */
    private $propertiesToReturn = [
        DataSourceInterface::NAME,
        DataSourceInterface::FULL_NAME,
        DataSourceInterface::FORKS_COUNT,
        DataSourceInterface::SUBSCRIBERS_COUNT,
        DataSourceInterface::WATCHERS_COUNT,
        DataSourceInterface::STARS_COUNT,
    ];

    /**
     * BasicRepositoryData constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @inheritdoc
     */
    public function fetchData(array $repository): Collection
    {
        return $this->githubClient->fetchRepositoryData(
            $repository['owner'], $repository['repo']
        )->only($this->propertiesToReturn);
    }

    /**
     * @inheritdoc
     */
    public function getErrorMessage(): string
    {
        return "Couldn't fetch basic repository data";
    }
}
