<?php

namespace App\Upwork;

use Carbon\Carbon;
use Log;
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
     * @throws \Exception
     */
    public function __construct($accessToken = null, $accessSecret = null, $perPage = 99)
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

            // An unknown error encountered.
            if ($response->error) {
                Log::error('API call to query jobs failed.', ['error' => $response->error]);
                break;
            }

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

        $jobs = $this->getAPIJobSpecificData($jobs);

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

    /**
     * @param array $jobs
     *
     * @return array
     */
    public function getAPIJobSpecificData(array $jobs)
    {
        $profile = new \Upwork\API\Routers\Jobs\Profile($this->client());
        $data    = [];

        // We chunk as the endpoint allows a max of 20 keys.
        $chunks = array_chunk($jobs, 20);
        foreach ($chunks as $chunk) {
            $ids = array_map(function ($job) {
                return $job->id;
            }, $chunk);

            // Format ids separated by ;
            $key = implode($ids, ';');

            // Query the API.
            $response = $profile->getSpecific($key);

            // All good, we merge.
            if ( ! $response->error) {
                $data = array_merge($data, $response->profiles->profile);
                continue;
            }

            // An error was thrown while trying to get the data in bulk.
            // As we can't know which of the jobs triggered the error we will
            // now query for each job individually.
            foreach ($ids as $id) {
                $response = $profile->getSpecific($id);

                // Found the job that had the error.
                if ($response->error) {
                    Log::error('API call to get extra data for job failed.', ['error' => $response->error]);
                    continue;
                }

                // Add job extra data.
                $data[] = $response->profile;
            }
        }

        // Merge jobs with the extra data.
        foreach ($jobs as $job) {
            $job->extra = collect($data)->first(function ($value) use ($job) {
                return $value->ciphertext === $job->id;
            });
        }

        return $jobs;
    }
}