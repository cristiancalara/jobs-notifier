<?php

namespace Tests\Unit;

use App\Job;
use App\Upwork\Filters\ContractorTierFilter;
use Tests\TestCase;

class ContractorTierFilterTest extends TestCase
{
    /** @test */
    public function it_will_filter_correctly()
    {
        $filter = new ContractorTierFilter();

        $toFail = factory(Job::class)->make([
            'extra' => [
                'op_contractor_tier' => '1'
            ]
        ]);

        $toPass1 = factory(Job::class)->make([
            'extra' => [
                'op_contractor_tier' => '3'
            ]
        ]);

        $toPass2 = factory(Job::class)->make([
            'extra' => [
                'op_contractor_tier' => null
            ]
        ]);

        $toPass3 = factory(Job::class)->create([
            'extra' => null
        ]);

        $this->assertFalse($filter->pass($toFail));
        $this->assertTrue($filter->pass($toPass1));
        $this->assertTrue($filter->pass($toPass2));
        $this->assertTrue($filter->pass($toPass3));
    }
}
