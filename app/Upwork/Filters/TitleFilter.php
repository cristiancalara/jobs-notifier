<?php

namespace App\Upwork\Filters;

use App\Job;

class TitleFilter extends Filter
{
    public function pass(Job $job): bool
    {
        $title = strtolower($job->title);

        $whitelist = [
            'vue',
            'vue.js',
            'laravel',
            'wordpress',
            'wp',
            'woocommerce',
            'imagick',
            'node',
            'node.js',
            'nodejs',
            'express',
            'expressjs',
            'express.js',
            'facebook',
            'graph api',
            'google ads',
            'phpunit'
        ];

        // If we find a word from the above we don't check for word in blacklist.
        if (str_contains_word($title, $whitelist)) {
            return true;
        }

        $blacklist = [
            'c#',
            'react',
            'reactjs',
            'react.js',
            'angular',
            'angularjs',
            'angular.js',
            'asp.net',
            'shopify',
            'prestashop',
            'timber',
            'kotlin',
            'bitrix',
            'hubspot',
            'java spring',
            'drupal',
            'ruby',
            'joomla',
            'elementor',
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
            'google sheet',
            'google sheets',
            'chrome extension',
            'chrome extensions',
            'zoho desk',
            'zapier',
            'drift',
            'golang',
            'openemr',
            'python',
            'java',
            'django',
            'flask',
            'android',
            'sails.js',
            'mern',
            'magento',
            'duda',
            'game development',
            'page speed optimization',
            'load speed',
            'website speed',
            'whmcs',
            'cakephp',
            'fabricjs',
            'typescript',
            'ios',
            'chatbot',
            'web designer',
            'blockchain',
        ];


        // If we find any of this words we fail.
        return ! str_contains_word($title, $blacklist);
    }
}