<?php

namespace Tests\Unit;

use App\Job;
use App\Upwork\Client;
use App\Upwork\Importer;
use App\User;
use Carbon\Carbon;
use Mockery;
use Tests\TestCase;

class UpworkImporterTest extends TestCase
{
    /** @test */
    public function it_will_import_to_database()
    {
        $jobs = $this->dummyResponse();
        list($client, $user) = $this->getClientAndUser($jobs);

        (new Importer($user, $client))->import();

        $this->assertCount(2, Job::all());
    }

    /** @test */
    public function it_will_not_import_based_on_filters()
    {
        $jobs                  = $this->dummyResponse();
        $jobs[0]->subcategory2 = 'Not wanted';

        list($client, $user) = $this->getClientAndUser($jobs);

        (new Importer($user, $client))->import();

        $this->assertCount(1, Job::all());
    }

    /**
     *
     * @return array
     */
    private function dummyResponse()
    {
        return [
            (object)[
                'id'           => '~01331cb9ce0b63f89a',
                'title'        => 'Laravel developer for affiliate based E-commerce website​',
                'snippet'      => 'We need an experienced laravel developer that has deep knowledge working with e-commerce websites linked to affiliate networks like LinkShare, Awin, and others. 

The back-end system has to work so we can register purchases from our users. 

Second phase of the project will be to deploy some new HTML pages.',
                'category2'    => 'Web, Mobile & Software Dev',
                'subcategory2' => 'Ecommerce Development',
                'skills'       => [
                    'affiliate-marketing',
                    'google-cloud-platform',
                    'html',
                    'javascript',
                    'laravel-framework',
                    'php',
                    'website-development',
                ],
                'job_type'     => 'Fixed',
                'budget'       => 200,
                'duration'     => null,
                'workload'     => null,
                'job_status'   => 'Open',
                'date_created' => '2019-02-14T16:01:03+0000',
                'url'          => 'http://www.upwork.com/jobs/~01331cb9ce0b63f89a',
                'client'       => (object)[
                    'country'                     => 'Singapore',
                    'feedback'                    => 4.6697419912,
                    'reviews_count'               => 12,
                    'jobs_posted'                 => 33,
                    'past_hires'                  => 18,
                    'payment_verification_status' => 'VERIFIED',
                ],
            ],
            (object)[
                'id'           => '~0172c3176941fd9b0e',
                'title'        => 'Looking for full stack web developer',
                'snippet'      => 'I am looking for senior full stack developer. 
The candidate should be available between 8am and 3 or 4pm CST. 
This will be 3+ months project if your skill is good for us.
If you are good fit, please send proposal with $kype id.',
                'category2'    => 'Web, Mobile & Software Dev',
                'subcategory2' => 'Web Development',
                'skills'       => [
                    'css',
                    'css3',
                    'html',
                    'html5',
                    'javascript',
                    'jquery',
                    'php',
                    'web-design',
                    'website-development',
                    'wordpress',
                ],
                'job_type'     => 'Hourly',
                'budget'       => 0,
                'duration'     => '1 to 3 months',
                'workload'     => '30+ hrs/week',
                'job_status'   => 'Open',
                'date_created' => '2019-02-14T15:59:58+0000',
                'url'          => 'http://www.upwork.com/jobs/~0172c3176941fd9b0e',
                'client'       => (object)[
                    'country'                     => 'Greece',
                    'feedback'                    => 0,
                    'reviews_count'               => 0,
                    'jobs_posted'                 => 1,
                    'past_hires'                  => 0,
                    'payment_verification_status' => 'VERIFIED',
                ]
            ]
        ];
    }

    /**
     * @param $jobs
     *
     * @return array
     */
    protected function getClientAndUser($jobs): array
    {
        $client = Mockery::mock(Client::class)->makePartial();
        $client->shouldReceive([
            'setAccessToken'  => null,
            'setAccessSecret' => null,
            'jobs'            => $jobs,
        ]);

        $user = factory(User::class)->create([
            'access_token'     => env('TEST_UPWORK_ACCESS_TOKEN'),
            'access_secret'    => env('TEST_UPWORK_ACCESS_SECRET'),
            'last_imported_at' => Carbon::minValue()->toDateString()
        ]);

        return array($client, $user);
    }
}
