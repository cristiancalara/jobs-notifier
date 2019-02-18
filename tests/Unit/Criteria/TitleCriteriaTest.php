<?php

namespace Tests\Unit;

use App\Job;
use App\Upwork\Rating\Criteria\TitleCriteria;
use Tests\TestCase;

class TitleCriteriaTest extends TestCase
{
    /** @test */
    public function return_correct_nr_of_points()
    {
        $criteria = new TitleCriteria();

        $max = factory(Job::class)->create([
            'title' => 'something node.js title'
        ]);

        $min = factory(Job::class)->create([
            'title' => 'something urgent title'
        ]);

        $other = factory(Job::class)->create([
            'title' => 'This will pass'
        ]);

        $this->assertEquals($criteria->maxPoints(), $criteria->apply($max));
        $this->assertEquals($criteria->minPoints(), $criteria->apply($min));
        $this->assertEquals(0, $criteria->apply($other));
    }
}
