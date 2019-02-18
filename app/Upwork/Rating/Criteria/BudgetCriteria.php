<?php

namespace App\Upwork\Rating\Criteria;

use App\Job;
use Carbon\Carbon;

class BudgetCriteria extends Criteria
{

    public function __construct()
    {
        parent::__construct(-20, 5);
    }

    /**
     *
     * @param Job $job
     *
     * @return int
     */
    function apply(Job $job): int
    {
        $budget = $job->budget;

        if ($budget > 10 && $budget < 200) {
            return $this->min;
        }

        if ($budget > 1000) {
            return $this->max;
        }

        return 0;
    }
}