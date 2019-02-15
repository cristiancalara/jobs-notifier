<?php

namespace App\Upwork\Rating\Criteria;

use App\Job;

abstract class Criteria
{
    /**
     * @var Job
     */
    protected $job;

    /**
     * @var int
     */
    protected $min;

    /**
     * @var int
     */
    protected $max;

    /**
     * Criteria constructor.
     *
     * @param int $min
     * @param int $max
     */
    public function __construct(int $min, int $max)
    {
        $this->min = $min;
        $this->max = $max;
    }


    /**
     * The points for the job.
     *
     * @param Job $job
     *
     * @return int
     */
    abstract function apply(Job $job): int;


    /**
     * Min number of points allowed by this criteria.
     *
     * @return int
     */
    function minPoints(): int
    {
        return $this->min;
    }

    /**
     * Max number of points allowed by this criteria.
     *
     * @return int
     */
    function maxPoints(): int
    {
        return $this->max;
    }
}