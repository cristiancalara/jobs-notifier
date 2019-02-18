<?php

namespace App\Upwork\Rating\Criteria;

use App\Job;
use Carbon\Carbon;

class DateCreatedCriteria extends Criteria
{

    public function __construct()
    {
        parent::__construct(-23, 23);
    }

    /**
     * We check the creation date of the job.
     * If it's sooner than one day we add one point per each hour.
     * If it's later than one day we subtract one point per each hour.
     *
     * @param Job $job
     *
     * @return int
     */
    function apply(Job $job): int
    {
        $yesterday = Carbon::now()->subDay();
        $date      = $job->date_created;

        $hours = $yesterday->diffInHours($date, false);

        if ($hours < $this->min) {
            $hours = $this->min;
        }

        if ($hours > $this->max) {
            $hours = $this->max;
        }

        return $hours;
    }
}