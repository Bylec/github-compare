<?php

namespace App\GithubCompare;

use App\GithubCompare\DataSources\DataSourceInterface;
use Illuminate\Support\Collection;

class RepositoriesBucket
{
    /**
     * Collection properties to be returned.
     *
     * @var array
     */
    private $compareFieldProperties = [
        DataSourceInterface::NAME,
        DataSourceInterface::FULL_NAME,
        DataSourceInterface::FORKS_COUNT,
        DataSourceInterface::SUBSCRIBERS_COUNT,
        DataSourceInterface::WATCHERS_COUNT,
        DataSourceInterface::STARS_COUNT,
        DataSourceInterface::LAST_RELEASE_DATE,
        DataSourceInterface::CLOSED_MERGE_REQUESTS_COUNT,
        DataSourceInterface::ALL_MERGE_REQUESTS_COUNT,
    ];

    /**
     * Map of properties and field names to return
     *
     * @var string[]
     */
    private $compareFieldsToReturnPropertyMap = [
        DataSourceInterface::NAME => 'repository_owner_name',
        DataSourceInterface::FULL_NAME => 'repository_full_name',
        DataSourceInterface::LAST_RELEASE_DATE => 'last_release_date',
        DataSourceInterface::STARS_COUNT => 'stars_count'
    ];

    /**
     * Collection of fetched repositories data.
     *
     * @var Collection $repositories
     */
    private $repositories;

    /**
     * RepositoriesBucket constructor.
     */
    public function __construct()
    {
        $this->repositories = collect();
    }

    /**
     * Checks if collection of repositories is empty.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return $this->repositories->isEmpty();
    }

    /**
     * Adds repository data to repositories collection.
     *
     * @param Collection $repository
     */
    public function addRepository(Collection $repository)
    {
        $this->repositories->push($repository);
    }

    /**
     * Returns parsed repositories data.
     *
     * @return array
     */
    public function getResult(): array
    {
        if ($this->repositories->count() === 1) {
            return $this->getSingleResult();
        }

        return $this->getManyResult();
    }

    /**
     * Returns repository data if its only one in repositories collection.
     *
     * @return array
     */
    private function getSingleResult(): array
    {
        return $this->repositories
            ->first()
            ->mapWithKeys(function ($value, $property) {
                return [
                    $this->getReturnFieldProperty($property) => $value
                ];
            })
            ->toArray();
    }

    /**
     * Returns repositories data if there are many repositories in collection.
     *
     * @return array
     */
    private function getManyResult(): array
    {
        $result = [];

        foreach ($this->compareFieldProperties as $fieldProperty) {
            $result[$this->getReturnFieldProperty($fieldProperty)] = $this->repositories->pluck($fieldProperty);
        }

        return $result;
    }

    /**
     * Gets property name to be returned.
     *
     * @param string $compareFieldProperty
     *
     * @return string
     */
    private function getReturnFieldProperty(string $compareFieldProperty): string
    {
        return $this->compareFieldsToReturnPropertyMap[$compareFieldProperty] ?? $compareFieldProperty;
    }
}
