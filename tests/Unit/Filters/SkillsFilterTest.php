<?php

namespace Tests\Unit;

use App\Job;
use App\Upwork\Filters\SkillsFilter;
use Tests\TestCase;

class SkillsFilterTest extends TestCase
{
    /** @test */
    public function it_will_filter_correctly()
    {
        $filter = new SkillsFilter();

        $toFail = factory(Job::class)->make([
            'skills' => ['react-js']
        ]);

        $toPass = factory(Job::class)->make([
            'skills' => ['something-else']
        ]);

        $whitelist = factory(Job::class)->make([
            'skills' => ['react-js', 'vue.js']
        ]);

        $this->assertFalse($filter->pass($toFail));
        $this->assertTrue($filter->pass($toPass));
        $this->assertTrue($filter->pass($whitelist));
    }
}
