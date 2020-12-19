<?php

namespace App\Services;

interface GithubServiceInterface
{
    public function compareRepositories(array $repositories);
}
