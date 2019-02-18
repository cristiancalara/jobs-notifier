<?php

namespace App\Upwork\Filters;

use App\Job;

class TitleFilter extends Filter
{
    public function pass(Job $job): bool
    {
        $blacklist = [
            '.net',
            'asp.net',
            'shopify',
            'prestashop',
            'kotlin',
            'bitrix',
            'java spring',
            'drupal',
            'ruby',
            'joomla',
            'elementor pro',
            'pyrocms',
            'weebly',
            'squarespace',
        ];

        $title = strtolower($job->title);

        // If we find any of this words we fail.
        foreach ($blacklist as $word) {
            if (strpos($title, $word) !== false) {
                return false;
            }
        }

        return true;
    }
}