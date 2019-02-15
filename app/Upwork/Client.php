<?php

namespace App\Upwork;

use Carbon\Carbon;
use Upwork\API\Routers\Jobs\Search;

class Client
{
    /**
     * @var \Upwork\API\Config
     */
    private $config;

    /**
     * @var int
     */
    private $perPage;

    /**
     * Client constructor.
     *
     * @param null $accessToken
     * @param null $accessSecret
     * @param int $perPage
     *
     * @throws \Upwork\API\ApiException
     */
    public function __construct($accessToken = null, $accessSecret = null, $perPage = 10)
    {
        $this->config = new \Upwork\API\Config([
            'consumerKey'    => env('UPWORK_APP_KEY'),
            'consumerSecret' => env('UPWORK_APP_SECRET_KEY')
        ]);

        if ($accessToken) {
            $this->setAccessToken($accessToken);
        }

        if ($accessSecret) {
            $this->setAccessSecret($accessSecret);
        }

        $this->perPage = $perPage;
    }

    /**
     * @param $token
     */
    public function setAccessToken($token)
    {
        $this->config->set('accessToken', $token);
    }

    /**
     * @param $token
     */
    public function setAccessSecret($token)
    {
        $this->config->set('accessSecret', $token);
    }

    /**
     * @return \Upwork\API\Client
     */
    public function client()
    {
        return new \Upwork\API\Client($this->config);
    }

    /**
     * @return mixed
     */
    public function auth()
    {
        return $this->client()->auth();
    }

    /**
     * All jobs since $since ordered by create time asc.
     *
     * @param Carbon $since
     * @param array $params
     *
     * @return array
     */
    public function jobs(Carbon $since, array $params = [])
    {
        $jobs   = [];
        $offset = 0;

        $params = array_merge($params, [
            "category2" => "Web, Mobile & Software Dev",
            "sort"      => "create_time desc"
        ]);

        // Paginate.
        $createdAt = null;
        do {
            $params["paging"] = "{$offset};{$this->perPage}";

            // Get jobs.
            $response = $this->queryApiForJobs($params);

            // No more jobs.
            if ( ! $response && ! $response->jobs) {
                break;
            }

            foreach ($response->jobs as $job) {
                $createdAt = new Carbon($job->date_created);

                // We reached the last imported job.
                if ($since->gte($createdAt)) {
                    break;
                }

                $jobs[] = $job;
            }

            $offset += $this->perPage;
        } while ($createdAt && $since->lt($createdAt));

        // Reverse the order to have the latest job the the latest entry.
        return array_reverse($jobs);
    }

    /**
     * @param $params
     *
     * @return object
     */
    public function queryApiForJobs($params)
    {
        $searchService = new Search($this->client());

        return $searchService->find($params);
    }
}