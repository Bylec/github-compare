<?php

namespace App\Http\Controllers;

use App\Services\GithubServiceInterface;
use Illuminate\Http\Request;

class GithubController extends Controller
{
    private $githubService;

    /**
     * GithubController constructor.
     *
     * @param GithubServiceInterface $githubService
     */
    public function __construct(GithubServiceInterface $githubService)
    {
        $this->githubService = $githubService;
    }

    /**
     * Controller method which compares repositories data.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function compare(Request $request)
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

        $result = $this->githubService
            ->compareRepositories(
                $request->get("repositories")
            );

        if (empty($result)) {
            return response()->json(
                [
                    "error" => "Could not find any repository."
                ],
                404
            );
        }

        return response()->json($result, 200);
    }
}
