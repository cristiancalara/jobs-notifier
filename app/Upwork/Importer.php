<?php

namespace App\Upwork;

use App\Upwork\Filters\Filter;
use App\Upwork\Filters\SubcategoryFilter;
use App\Upwork\Filters\TitleFilter;
use App\User;
use App\Job;
use Carbon\Carbon;

class Importer
{
    /**
     * @var \Upwork\API\Client
     */
    private $client;

    /**
     * @var User
     */
    private $user;

    /**
     * @var Filter[]
     */
    private $filters;

    /**
     * Client constructor.
     *
     * @param User $user
     * @param Client $client
     *
     * @throws \Upwork\API\ApiException
     */
    public function __construct(User $user, Client $client = null)
    {
        $this->user = $user;

        $this->client = $client ?? new Client();
        $this->client->setAccessToken($user->access_token);
        $this->client->setAccessSecret($user->access_secret);

        $this->filters = [
            new SubcategoryFilter,
            new TitleFilter,
        ];
    }

    public function import()
    {
        $since = $this->user->last_imported_at ?? Carbon::now()->subMinutes(5);
        $jobs  = $this->client->jobs($since);

        if ( ! $jobs) {
            return;
        }

        $model = null;
        foreach ($jobs as $job) {
            $model = Job::fromAPI($job);

            if ( ! $this->passFilters($model)) {
                continue;
            }

            $model->user_id = $this->user->id;
            $model->save();
        }

        // Update the last imported at with the latest job we imported.
        $this->user->last_imported_at = $model->date_created;
        $this->user->save();
    }

    /**
     * @param Job $job
     *
     * @return bool
     */
    protected function passFilters(Job $job)
    {
        foreach ($this->filters as $filter) {
            if ( ! $filter->pass($job)) {
                return false;
            }
        }

        return true;
    }
}