<?php

namespace App\Upwork\Rating\Criteria;

use App\Job;

class ContractorTierCriteria extends Criteria
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
        // 1=beginner, 2=intermediate, 3=expert
        $tier = $job->extra['op_contractor_tier'] ?? null;

        if ($tier && $tier == 3) {
            return $this->max;
        }

        if ($tier && $tier == 2) {
            return $this->min;
        }

        // 1=beginner is filtered out
        return 0;
    }
}