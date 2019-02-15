<?php

namespace App\Upwork\Rating\Criteria;

use App\Job;
use Carbon\Carbon;

class DateCreatedCriteria extends Criteria
{

    public function __construct()
    {
        parent::__construct(0, 0);
    }

    /**
     * @param Job $job
     *
     * @return int
     */
    function apply(Job $job): int
    {
        return 0;
    }
}