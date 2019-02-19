<?php

namespace App\Upwork\Rating\Criteria;

use App\Job;

class TitleCriteria extends Criteria
{

    public function __construct()
    {
        parent::__construct(-20, 20);
    }

    function apply(Job $job): int
    {
        $title = strtolower($job->title);

        if (str_contains_word($title, [
            'node.js',
            'express.js',
            'laravel',
            'wordpress',
            'woocommerce',
            'vue',
            'vue.js',
            'full stack',
            'full-stack'
        ])) {
            return 20;
        }

        if (str_contains_word($title, [
            'angular',
            'react'
        ])) {
            return -10;
        }

        if (str_contains_word($title, [
            'urgent',
            'immediately'
        ])) {
            return -20;
        }

        return 0;
    }
}