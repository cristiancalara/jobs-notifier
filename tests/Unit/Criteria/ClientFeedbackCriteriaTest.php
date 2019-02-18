<?php

namespace Tests\Unit;

use App\Job;
use App\Upwork\Rating\Criteria\ClientFeedbackCriteria;
use Tests\TestCase;

class ClientFeedbackCriteriaTest extends TestCase
{
    /** @test */
    public function return_correct_nr_of_points()
    {
        $criteria = new ClientFeedbackCriteria();

        $noReviews = factory(Job::class)->create([
            'client' => [
                'reviews_count' => 0
            ]
        ]);

        $max = factory(Job::class)->create([
            'client' => [
                'reviews_count' => 2,
                'feedback'      => 4.51
            ]
        ]);

        $min = factory(Job::class)->create([
            'client' => [
                'reviews_count' => 2,
                'feedback'      => 2.99
            ]
        ]);

        $other = factory(Job::class)->create([
            'client' => [
                'reviews_count' => 2,
                'feedback'      => 3.5
            ]
        ]);

        $this->assertEquals(0, $criteria->apply($noReviews));
        $this->assertEquals($criteria->maxPoints(), $criteria->apply($max));
        $this->assertEquals($criteria->minPoints(), $criteria->apply($min));
        $this->assertEquals(-20, $criteria->apply($other));
    }
}
