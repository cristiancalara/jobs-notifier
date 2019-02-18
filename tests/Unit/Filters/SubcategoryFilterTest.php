<?php

namespace Tests\Unit;

use App\Job;
use App\Upwork\Filters\SubcategoryFilter;
use Tests\TestCase;

class SubcategoryFilterTest extends TestCase
{
    /** @test */
    public function it_will_filter_correctly()
    {
        $filter = new SubcategoryFilter();

        $toFail = factory(Job::class)->make([
            'subcategory2' => 'Category not wanted'
        ]);

        $toPass = factory(Job::class)->make([
            'subcategory2' => 'Ecommerce Development'
        ]);


        $this->assertFalse($filter->pass($toFail));
        $this->assertTrue($filter->pass($toPass));
    }
}
