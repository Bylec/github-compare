<?php

namespace App\GithubCompare;

use App\GithubCompare\DataSources\BasicRepositoryData;
use App\GithubCompare\DataSources\MergeRequestData;
use App\GithubCompare\DataSources\RepositoryReleasesData;
use Exception;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class RepositoryDataAggregator
{
    /**
     * Data for repository that data is going to be fetched.
     *
     * @var array $repository
     */
    private $repository;

    /**
     *  Data sources.
     *
     * @var string[] $dataSources
     */
    private $dataSources = [
        BasicRepositoryData::class,
        RepositoryReleasesData::class,
        MergeRequestData::class
    ];

    /**
     * RepositoryDataAggregator constructor.
     *
     * @param array $repository
     */
    public function __construct(array $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Aggregates data from sources api calls.
     *
     * @return Collection
     */
    public function aggregate(): Collection
    {
        $mergedCollection = collect();

        foreach ($this->dataSources as $source) {
            $sourceObject = new $source();
            try {
                $mergedCollection = $mergedCollection->merge(
                    $sourceObject->fetchData($this->repository)
                );
            } catch (RequestException $e) {
                Log::error($sourceObject->getErrorMessage() . ". " . $e->getMessage());
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        }

        return $mergedCollection;
    }
}
