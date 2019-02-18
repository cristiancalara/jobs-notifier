<?php

namespace Tests\Unit;

use App\Job;
use App\Upwork\Rating\Criteria\BudgetCriteria;
use Tests\TestCase;

class BudgetCriteriaTest extends TestCase
{
    /** @test */
    public function return_correct_nr_of_points()
    {
        $criteria = new BudgetCriteria();

        $max = factory(Job::class)->create([
            'budget' => 1001
        ]);

        $min = factory(Job::class)->create([
            'budget' => 11
        ]);

        $zeroBudget = factory(Job::class)->create([
            'budget' => 0
        ]);

        $this->assertEquals($criteria->maxPoints(), $criteria->apply($max));
        $this->assertEquals($criteria->minPoints(), $criteria->apply($min));
        $this->assertEquals(0, $criteria->apply($zeroBudget));
    }
}
