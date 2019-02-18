<?php

namespace App\Upwork\Filters;

use App\Job;

class SubcategoryFilter extends Filter
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
        return in_array($job->subcategory2, [
            "Web Development",
            "Ecommerce Development",
            "Scripts & Utilities",
            "Other - Software Development"
        ]);
    }
}