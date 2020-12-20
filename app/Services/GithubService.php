<?php

namespace App\Services;

use App\GithubCompare\RepositoriesBucket;
use App\GithubCompare\RepositoryDataAggregator;

class GithubService implements GithubServiceInterface
{
    /**
     * Compares data between given repositories.
     *
     * @param array $repositories
     *
     * @return array
     */
    public function compareRepositories(array $repositories): array
    {
        $repositoriesBucket = new RepositoriesBucket();

        foreach ($repositories as $repository) {
            $repositoryDataAggregator = new RepositoryDataAggregator($repository);
            $repositoriesBucket->addRepository(
                $repositoryDataAggregator->aggregate()
            );
        }

        if ($repositoriesBucket->isEmpty()) {
            return [];
        }

        return $repositoriesBucket->getResult();
    }
}
