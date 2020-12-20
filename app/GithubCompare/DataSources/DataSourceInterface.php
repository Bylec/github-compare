<?php

namespace App\GithubCompare\DataSources;

use Illuminate\Support\Collection;

interface DataSourceInterface
{
    const NAME = 'name';
    const FULL_NAME = 'full_name';
    const FORKS_COUNT = 'forks_count';
    const SUBSCRIBERS_COUNT = 'subscribers_count';
    const WATCHERS_COUNT = 'watchers_count';
    const STARS_COUNT = 'stargazers_count';
    const LAST_RELEASE_DATE = 'created_at';
    const CLOSED_MERGE_REQUESTS_COUNT = 'closed_merge_requests';
    const ALL_MERGE_REQUESTS_COUNT = 'all_merge_requests';

    /**
     * Fetches source data from Github API.
     *
     * @param array $repository
     *
     * @return Collection
     */
    public function fetchData(array $repository): Collection;

    /**
     * Returns error message in case of Github API call fails.
     *
     * @return string
     */
    public function getErrorMessage(): string;
}
