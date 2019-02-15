<?php

namespace Tests\Unit;

use App\Job;
use Tests\TestCase;

class JobTest extends TestCase
{
    /** @test */
    public function has_rating()
    {
        $job = factory(Job::class)->create();

        $score = $job->rating;

        $this->assertIsNumeric($score);
        $this->assertLessThanOrEqual(100, $score);
        $this->assertGreaterThanOrEqual(0, $score);
    }
}
