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

        $toFail1 = factory(Job::class)->make([
            'title' => 'Something react.js not wanted'
        ]);

        $toFail2 = factory(Job::class)->make([
            'title' => 'Something Google Sheets not wanted'
        ]);

        $toFail3 = factory(Job::class)->make([
            'title' => 'Something Angular/React.js not wanted'
        ]);

        $toPass1 = factory(Job::class)->make([
            'title' => 'This will pass'
        ]);

        $toPass2 = factory(Job::class)->make([
            'title' => 'This strVBAtest pass'
        ]);

        $whitelist = factory(Job::class)->make([
            'title' => 'Test Vue/React/Angular'
        ]);

        $this->assertFalse($filter->pass($toFail1));
        $this->assertFalse($filter->pass($toFail2));
        $this->assertFalse($filter->pass($toFail3));
        $this->assertTrue($filter->pass($toPass1));
        $this->assertTrue($filter->pass($toPass2));
        $this->assertTrue($filter->pass($whitelist));
    }
}
