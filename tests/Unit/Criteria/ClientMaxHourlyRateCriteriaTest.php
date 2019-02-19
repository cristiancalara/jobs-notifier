<?php

namespace Tests\Unit;

use App\Job;
use App\Upwork\Rating\Criteria\ClientMaxHourlyRateCriteria;
use Tests\TestCase;

class ClientMaxHourlyRateCriteriaTest extends TestCase
{
    /** @test */
    public function return_correct_nr_of_points()
    {
        $criteria = new ClientMaxHourlyRateCriteria();

        $noAssignments = factory(Job::class)->create([
            'extra' => [
                'assignments' => ''
            ]
        ]);

        $notEnoughHours = factory(Job::class)->create([
            'extra' => [
                'assignments' => [
                    'assignment' => [
                        [
                            'as_job_type'    => 'Hourly',
                            'as_rate'        => '$50.00',
                            'as_total_hours' => '4'
                        ]
                    ]
                ]
            ]
        ]);

        $max = factory(Job::class)->create([
            'extra' => [
                'assignments' => [
                    'assignment' => [
                        [
                            'as_job_type'    => 'Hourly',
                            'as_rate'        => '$50.00',
                            'as_total_hours' => '6'
                        ]
                    ]
                ]
            ]
        ]);

        $min = factory(Job::class)->create([
            'extra' => [
                'assignments' => [
                    'assignment' => [
                        [
                            'as_job_type'    => 'Hourly',
                            'as_rate'        => '$24.00',
                            'as_total_hours' => '6'
                        ]
                    ]
                ]
            ]
        ]);

        $other = factory(Job::class)->create([
            'extra' => [
                'assignments' => [
                    'assignment' => [
                        [
                            'as_job_type'    => 'Hourly',
                            'as_rate'        => '$36.00',
                            'as_total_hours' => '6'
                        ]
                    ]
                ]
            ]
        ]);

        $this->assertEquals(0, $criteria->apply($noAssignments));
        $this->assertEquals(0, $criteria->apply($notEnoughHours));
        $this->assertEquals($criteria->maxPoints(), $criteria->apply($max));
        $this->assertEquals($criteria->minPoints(), $criteria->apply($min));
        $this->assertEquals(10, $criteria->apply($other));
    }
}
