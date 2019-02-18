<?php

namespace Tests\Unit;

use App\Job;
use App\Upwork\Rating\Criteria\ClientCountryCriteria;
use Tests\TestCase;

class ClientCountryCriteriaTest extends TestCase
{
    /** @test */
    public function return_correct_nr_of_points()
    {
        $criteria = new ClientCountryCriteria();

        $max = factory(Job::class)->create([
            'client' => [
                'country' => 'Australia'
            ]
        ]);

        $min = factory(Job::class)->create([
            'client' => [
                'country' => 'Pakistan'
            ]
        ]);

        $other = factory(Job::class)->create([
            'client' => [
                'country' => 'United States'
            ]
        ]);

        $this->assertEquals($criteria->maxPoints(), $criteria->apply($max));
        $this->assertEquals($criteria->minPoints(), $criteria->apply($min));
        $this->assertEquals(0, $criteria->apply($other));
    }
}
