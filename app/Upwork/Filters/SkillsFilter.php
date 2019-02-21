<?php

namespace App\Upwork\Filters;

use App\Job;

class SkillsFilter extends Filter
{
    public function pass(Job $job): bool
    {
        $skills = $job->skills;

        $whitelist = [
            'vue.js',
            'psd-to-html',
            'psd-to-wordpress',
            'wordpress',
            'wordpress-plugin',
            'woocommerce',
            'laravel-framework',
            'facebook-api',
            'd3.js',
            'express-js',
        ];

        // If we find at least one skill from the whitelist in the array we pass.
        if (array_intersect($skills, $whitelist)) {
            return true;
        }

        $blacklist = [
            'c',
            'c++',
            'c#',
            'ruby',
            'python',
            'asp.net',
            'kotlin',
            'typescript',
            'vba',
            'arduino',
            'android',
            'ios-sdk',
            'ios-development',
            'golang',

            'flask',
            'react-js',
            'meteor.js',
            'nuxt.js',
            'fabric.js',

            'silex-framework',
            'yii-framework',
            'yii2',
            'cakephp',

            'hubspot',
            'shopify',
            'prestashop',
            'drupal',
            'joomla',
            'magento',
            'opencart',
            'weebly',
            'squarespace',
            'typo3',
            'magento',
            'magento-2',
            'zoho-crm',

            'chatbot-development',
            'ux-design',
            'ux-research',
            'copyright',
            'copy-editing'
        ];


        // If we at least one skill from the blacklist in the array we fail.
        return ! array_intersect($skills, $blacklist);
    }
}