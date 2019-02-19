<?php

namespace Tests\Unit;

use App\Job;
use App\Upwork\Rating\Criteria\ContractorTierCriteria;
use Tests\TestCase;

class ContractorTierCriteriaTest extends TestCase
{
    /** @test */
    public function return_correct_nr_of_points()
    {
        $criteria = new ContractorTierCriteria();

        $max = factory(Job::class)->create([
            'extra' => [
                'op_contractor_tier' => '3'
            ]
        ]);

        $min = factory(Job::class)->create([
            'extra' => [
                'op_contractor_tier' => '2'
            ]
        ]);

        $noValue = factory(Job::class)->create([
            'extra' => [
                'op_contractor_tier' => null
            ]
        ]);

        $this->assertEquals($criteria->maxPoints(), $criteria->apply($max));
        $this->assertEquals($criteria->minPoints(), $criteria->apply($min));
        $this->assertEquals(0, $criteria->apply($noValue));
    }
}
