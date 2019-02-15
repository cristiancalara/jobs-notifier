<?php

namespace App\Upwork\Rating;

use App\Job;
use App\Upwork\Rating\Criteria\Criteria;

class Rating
{
    /**
     * @var Criteria[]
     */
    private $criteriaList;

    /**
     * @var int
     */
    private $minPoints;

    /**
     * @var int
     */
    private $maxPoints;

    /**
     * Score constructor.
     *
     * @param array $criteriaList
     */
    public function __construct(array $criteriaList)
    {
        $this->criteriaList = $criteriaList;
        $this->computeMinMax();
    }

    /**
     * @param Job $job
     *
     * @return float|int
     */
    public function for(Job $job)
    {
        $points = 0;
        foreach ($this->criteriaList as $criteria) {
            $points += $criteria->apply($job);
        }

        return $this->normalize($points) * 100;
    }

    protected function computeMinMax()
    {
        $this->minPoints = 0;
        $this->maxPoints = 0;
        foreach ($this->criteriaList as $criteria) {
            $this->minPoints += $criteria->minPoints();
            $this->maxPoints += $criteria->maxPoints();
        }
    }

    /**
     * @param $points
     *
     * @return float|int
     */
    protected function normalize($points)
    {
        return ($points - $this->minPoints) / ($this->maxPoints - $this->minPoints);
    }
}