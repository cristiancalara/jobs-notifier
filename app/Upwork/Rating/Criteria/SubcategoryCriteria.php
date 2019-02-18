<?php

namespace App\Upwork\Rating\Criteria;

use App\Job;

class SubcategoryCriteria extends Criteria
{

    public function __construct()
    {
        parent::__construct(-30, 30);
    }

    function apply(Job $job): int
    {
        switch ($job->subcategory2) {
            case 'Web Development':
            case 'Ecommerce Development':
                return $this->max;

            case 'Other - Software Development':
            case 'Scripts & Utilities':
                return 10;

            default:
                return 0;
        }
    }
}