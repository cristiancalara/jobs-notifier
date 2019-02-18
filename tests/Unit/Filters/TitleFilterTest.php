<?php

namespace Tests\Unit;

use App\Job;
use App\Upwork\Filters\SubcategoryFilter;
use App\Upwork\Filters\TitleFilter;
use Tests\TestCase;

class TitleFilterTest extends TestCase
{
    /** @test */
    public function it_will_filter_correctly()
    {
        $filter = new TitleFilter();

        $toFail = factory(Job::class)->make([
            'title' => 'Something .net not wanted'
        ]);

        $toPass = factory(Job::class)->make([
            'title' => 'This will pass'
        ]);


        $this->assertFalse($filter->pass($toFail));
        $this->assertTrue($filter->pass($toPass));
    }
}
