<?php

namespace App\Upwork\Rating\Criteria;

use App\Job;
use Carbon\Carbon;

class ClientCountryCriteria extends Criteria
{

    public function __construct()
    {
        parent::__construct(-20, 20);
    }

    /**
     *
     * @param Job $job
     *
     * @return int
     */
    function apply(Job $job): int
    {
        $client  = $job->client;
        $country = $client['country'];

        if ( ! $country) {
            return 0;
        }

        $good = [
            'Australia',
            'Ireland',
            'United Kingdom',
            'Norway',
            'Sweden',
            'Denmark',
            'Switzerland',
            'Germany',
            'France',
            'Finland',
            'Luxembourg',
            'Belgium',
            'Netherlands',
            'Canada',
            'Japan',
            'New Zealand'
        ];

        $bad = [
            'India',
            'Pakistan',
            'Belarus',
            'Indonesia',
            'Lebanon',
            'Morocco',
            'Malaysia',
            'Sri Lanka',
            'Ecuador',
            'Nigeria'
        ];

        if (in_array($country, $good)) {
            return $this->max;
        }

        if (in_array($country, $bad)) {
            return $this->min;
        }

        return 0;
    }
}