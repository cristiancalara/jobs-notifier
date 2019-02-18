<?php

namespace Tests\Unit;

use App\Job;
use App\Upwork\Rating\Criteria\DateCreatedCriteria;
use Carbon\Carbon;
use Tests\TestCase;

class DateCreatedCriteriaTest extends TestCase
{
    /** @test */
    public function return_correct_nr_of_points()
    {
        $criteria = new DateCreatedCriteria();

        $max = factory(Job::class)->create([
            'date_created' => Carbon::now()
        ]);

        $min = factory(Job::class)->create([
            'date_created' => Carbon::now()->subDays(2)
        ]);

        $other = factory(Job::class)->create([
            'date_created' => Carbon::now()->subDay()
        ]);

        $this->assertEquals($criteria->maxPoints(), $criteria->apply($max));
        $this->assertEquals($criteria->minPoints(), $criteria->apply($min));
        $this->assertEquals(0, $criteria->apply($other));
    }
}
