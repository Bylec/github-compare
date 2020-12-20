####Launching application

To launch application you need to run `composer install` command and copy `.env.example` to project root directory and rename it to `.env`.

After that run `php -S localhost:8000 -t public` command in project root directory.

####Solution

Application has only one endpoint to compare repositories. It connects to Github API using Guzzle and fetches repositories data.

`App\GithubCompareRepositoryDataAggregator` have `$dataSources` field which holds data sources. Each of them performs the api call after which data is aggregated into one single collection and pushed to `App\GithubCompare\RepositoriesBucket`.
You can easily add another data source if more information about repositories needed.

Unfortunately there is an issue with fetching merge requests data by `GET /repos/{owner}/{repo}/pulls` endpoint. It has a limit of 100 records returned by single call, so if repository has more merge requests, number of closed and all merge requests is going to be incorrect. I couldn't find more appropriate endpoint to achieve required results, and couldn't come up with better solution in limited time of six hours to complete task.

Application does not authorize to Github API because used endpoints are public and does not require it. It could be easily done by attaching personal access token to each of the requests. https://docs.github.com/en/free-pro-team@latest/github/authenticating-to-github/creating-a-personal-access-token . The only limitation when not authorizing is number of requests sent in specific time. 

####Requests documentation

##### Endpoint which compares repositories data

POST `localhost:8000/api/compare`

######Example Request
```
{
    "repositories": [
        {
            "owner": "Bylec",
            "repo": "bylec-chess"
        },
        {
            "owner": "vuejs",
            "repo": "vue"
        }
    ]
}
```

######Example Response

Each of object variables is array with compared repositories systematized data. 

```
{
    "repository_owner_name": [
        "bylec-chess",
        "vue"
    ],
    "repository_full_name": [
        "Bylec/bylec-chess",
        "vuejs/vue"
    ],
    "forks_count": [
        0,
        27579
    ],
    "subscribers_count": [
        1,
        6351
    ],
    "watchers_count": [
        0,
        176965
    ],
    "stars_count": [
        0,
        176965
    ],
    "last_release_date": [
        null,
        "2019-12-13T19:58:42Z"
    ],
    "closed_merge_requests": [
        0,
        65
    ],
    "all_merge_requests": [
        0,
        100
    ]
}
```
