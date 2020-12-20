<?php

namespace App\GithubCompare\DataSources;

use Illuminate\Support\Collection;

class RepositoryReleasesData extends AbstractDataSource
{
    /**
     * Properties to return from API call.
     *
     * @var array
     */
    private $propertiesToReturn = [
        DataSourceInterface::LAST_RELEASE_DATE
    ];

    /**
     * @inheritdoc
     */
    public function fetchData(array $repository): Collection
    {
        return $this->githubClient->fetchLatestRepositoryReleaseData(
            $repository['owner'], $repository['repo']
        )->only($this->propertiesToReturn);
    }

    /**
     * @inheritdoc
     */
    public function getErrorMessage(): string
    {
        return "Couldn't fetch repository releases data.";
    }
}
