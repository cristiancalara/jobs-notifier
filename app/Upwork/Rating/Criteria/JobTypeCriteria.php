<?php

namespace App\Upwork\Rating\Criteria;

use App\Job;

class JobTypeCriteria extends Criteria
{

    public function __construct()
    {
        parent::__construct(-10, 10);
    }

    function apply(Job $job): int
    {
        return $job->job_type == 'Fixed' ? $this->min : $this->max;
    }
}