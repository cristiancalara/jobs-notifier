<?php

namespace App\Upwork\Rating\Criteria;

use App\Job;

class ClientMaxHourlyRateCriteria extends Criteria
{

    public function __construct()
    {
        parent::__construct(-10, 20);
    }

    /**
     *
     * @param Job $job
     *
     * @return int
     */
    function apply(Job $job): int
    {
        $hoursPaid = $job->hours_paid;
        $maxRate   = $job->max_hourly_rate;

        if ($hoursPaid < 5) {
            return 0;
        }

        if ($maxRate > 45) {
            return $this->max;
        }

        if ($maxRate > 35) {
            return 10;
        }

        if ($maxRate > 25) {
            return 0;
        }

        return $this->min;
    }
}