<?php

namespace App\Upwork\Filters;

use App\Job;

class TitleFilter extends Filter
{
    public function pass(Job $job): bool
    {
        $blacklist = [
            'c#',
            'react.js',
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
            'vba',
            'silex',
            'code ignitor',
            'symfony',
            'opencart',
            'quasar',
            'meteor',
            'copy writer',
            'firebase',
            'nuxt.js',
            'divi',
            'typo3',
            'metatrader',
            'arduino',
            'yii',
            'google sheets',
            'google sheet',
            'google sheet',
            'chrome extension',
            'chrome extensions',
            'zoho desk',
            'drift',
            'golang',
            'openemr',
        ];

        $title = strtolower($job->title);

        // If we find any of this words we fail.
        return ! str_contains_word($title, $blacklist);
    }
}