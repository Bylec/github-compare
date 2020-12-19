<?php

namespace App\Http\Controllers;

use App\Services\GithubServiceInterface;
use Illuminate\Http\Request;

class GithubController extends Controller
{
    public function compare(Request $request, GithubServiceInterface $githubService)
    {
        $this->validate($request, [
            "repositories" => [
                "required",
                "array"
            ],
            "repositories.*.owner" => [
                "required",
                "string"
            ],
            "repositories.*.repo" => [
                "required",
                "string"
            ]
        ]);

        return $githubService->compareRepositories($request->get("repositories"));
    }
}
