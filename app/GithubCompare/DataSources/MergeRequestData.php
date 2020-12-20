<?php

namespace App\GithubCompare\DataSources;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class MergeRequestData extends AbstractDataSource
{
    /**
     * @inheritdoc
     */
    public function fetchData(array $repository): Collection
    {
        $mergeRequests = $this->githubClient->fetchMergeRequestRepositoryData(
            $repository['owner'], $repository['repo']
        );

        $closedMergeRequests = $mergeRequests->where("state", "closed")
            ->count();

        return collect([
            DataSourceInterface::CLOSED_MERGE_REQUESTS_COUNT => $closedMergeRequests,
            DataSourceInterface::ALL_MERGE_REQUESTS_COUNT => $mergeRequests->count()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getErrorMessage(): string
    {
        return "Couldn't get merge request data.";
    }
}
