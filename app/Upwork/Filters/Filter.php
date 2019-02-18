<?php

namespace App\Upwork\Filters;

use App\Job;

abstract class Filter
{
    abstract public function pass(Job $job): bool;
}