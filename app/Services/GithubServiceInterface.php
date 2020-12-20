<?php

namespace App\Services;

interface GithubServiceInterface
{
    /**
     * Compares data between given repositories.
     *
     * @param array $repositories
     *
     * @return array
     */
    public function compareRepositories(array $repositories): array;
}
