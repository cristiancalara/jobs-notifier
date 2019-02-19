<?php

namespace App\Upwork\Filters;

use App\Job;

class ContractorTierFilter extends Filter
{
    /**
     * We only allow jobs from these categories.
     *
     * @param Job $job
     *
     * @return bool
     */
    public function pass(Job $job): bool
    {
        $tier = $job->extra['op_contractor_tier'] ?? null;

        // We filter out the jobs that require a entry level freelancer
        // 1=beginner, 2=intermediate, 3=expert
        if ($tier && $tier == 1) {
            return false;
        }

        return true;
    }
}