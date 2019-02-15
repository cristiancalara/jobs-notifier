<?php

namespace Tests\Unit;

use App\Upwork\Client;
use Carbon\Carbon;
use Mockery;
use Tests\TestCase;

class UpworkClientTest extends TestCase
{
    /** @test */
    public function it_will_return_jobs_sorted_by_date_created_asc()
    {
        $perPage     = 3;
        $since       = new Carbon('2018-01-01T00:00:00+0000');
        $apiResponse = $this->getJobsResponse([
            '2019-03-01T00:00:00+0000',
            '2019-02-01T00:00:00+0000',
            '2019-01-01T00:00:00+0000'
        ]);

        $client = $this->getMock($perPage);
        $client->shouldReceive('queryApiForJobs')
               ->andReturn($apiResponse, [])
               ->times(2);


        $jobs = $client->jobs($since);

        $expected = array_reverse($apiResponse->jobs);

        $this->assertEquals($expected, $jobs);
    }

    /** @test */
    public function it_will_return_jobs_since_date()
    {
        $perPage     = 2;
        $sinceString = '2019-02-01T00:00:00+0000';
        $since       = new Carbon($sinceString);

        $client = $this->getMock($perPage);
        $client->shouldReceive('queryApiForJobs')
               ->andReturn(
                   $this->getJobsResponse(['2019-03-02T00:00:00+0000', '2019-03-01T00:00:00+0000']),
                   $this->getJobsResponse(['2019-02-02T00:00:00+0000', $sinceString]),
                   $this->getJobsResponse(['2018-01-02T00:00:00+0000', '2018-01-01T00:00:00+0000'])
               )
               ->times(2);


        $jobs = $client->jobs($since);

        $this->assertCount(3, $jobs);
    }

    /**
     * @param $perPage
     *
     * @return Client|Mockery\MockInterface
     */
    private function getMock($perPage)
    {
        $accessToken  = env('TEST_UPWORK_ACCESS_TOKEN');
        $accessSecret = env('TEST_UPWORK_ACCESS_SECRET');

        $mock = Mockery::mock(Client::class, [null, null, $perPage])
                       ->makePartial();

        $mock->setAccessToken($accessToken);
        $mock->setAccessSecret($accessSecret);

        return $mock;
    }

    /**
     * @param array $dates
     *
     * @return \stdClass
     */
    private function getJobsResponse(array $dates = [])
    {
        $jobs = [];

        foreach ($dates as $i => $date) {
            $jobs[] = (object)[
                'id'           => str_random(10),
                'date_created' => $date,
            ];
        }

        return $response = (object)[
            'jobs' => $jobs
        ];
    }
}
