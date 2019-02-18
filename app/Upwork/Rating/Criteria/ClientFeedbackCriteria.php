<?php

namespace App\Upwork\Rating\Criteria;

use App\Job;
use Carbon\Carbon;

class ClientFeedbackCriteria extends Criteria
{

    public function __construct()
    {
        parent::__construct(-40, 10);
    }

    /**
     *
     * @param Job $job
     *
     * @return int
     */
    function apply(Job $job): int
    {
        $client = $job->client;

        // We should account for the rating if there are not enough reviews.
        if ($client['reviews_count'] <= 1) {
            return 0;
        }

        if ($client['feedback'] > 4.5) {
            return 10;
        }

        if ($client['feedback'] > 4) {
            return 5;
        }

        if ($client['feedback'] > 3) {
            return -20;
        }

        return -40;
    }
}