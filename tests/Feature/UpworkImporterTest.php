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
                'id'           => '~01039681e7c1af5488',
                'title'        => 'Developer to Customize and Optimize an existing theme',
                'snippet'      => 'Deliverable
2. Implementing Google and FB Ad conversion pixels, Product listing ads
3. Optimizing theme for faster loading time

I\'m looking for a team that can work with me to polish the theme and get it ready for rollout and work with us till completion of the project and explore working in the future for further tweaks and customizations.',
                'category2'    => 'Web, Mobile & Software Dev',
                'subcategory2' => 'Ecommerce Development',
                'skills'       =>
                    [
                        0 => 'html',
                        1 => 'shopify',
                        2 => 'shopify-templates',
                        3 => 'web-design',
                    ],
                'job_type'     => 'Fixed',
                'budget'       => 400,
                'duration'     => null,
                'workload'     => null,
                'job_status'   => 'Open',
                'date_created' => '2019-02-19T05:47:11+0000',
                'url'          => 'http://www.upwork.com/jobs/~01039681e7c1af5488',
                'client'       =>
                    [
                        'country'                     => 'India',
                        'feedback'                    => 0,
                        'reviews_count'               => 0,
                        'jobs_posted'                 => 3,
                        'past_hires'                  => 0,
                        'payment_verification_status' => null,
                    ],
                'extra'        => [
                    'assignment_info'             => '',
                    'op_low_hourly_rate_all'      => '0',
                    'op_description'              => 'Deliverable
1. Customization of Fastor Shopify theme
2. Implementing Google and FB Ad conversion pixels, Product listing ads
3. Optimizing theme for faster loading time

I\'m looking for a team that can work with me to polish the theme and get it ready for rollout and work with us till completion of the project and explore working in the future for further tweaks and customizations.',
                    'op_required_skills'          => [
                        'op_required_skill' => [
                            [
                                'skill' => 'html',
                            ],

                            [
                                'skill' => 'shopify',
                            ],

                            [
                                'skill' => 'shopify-templates',
                            ],

                            [
                                'skill' => 'web-design',
                            ],
                        ],
                    ],
                    'op_ctime'                    => '1550555223000',
                    'job_type'                    => 'Fixed',
                    'op_pref_hourly_rate_min'     => '',
                    'op_title'                    => 'Shopify Developer to Customize and Optimize an existing theme',
                    'amount'                      => '400.00',
                    'op_job_category_v2'          => [
                        'op_job_category_v' => [
                            'name'   => 'Ecommerce Development',
                            'groups' => [
                                'group' => [
                                    'name' => 'Web, Mobile & Software Dev',
                                    'uid'  => '531770282580668418',
                                ],
                            ],
                        ],
                    ],
                    'op_additional_questions'     => '',
                    'job_category_level_two'      => '',
                    'op_attached_doc'             => '',
                    'op_pref_english_skill'       => '0',
                    'op_engagement'               => '',
                    'op_contractor_tier'          => '3',
                    'op_tot_feedback'             => '0',
                    'op_pref_has_portfolio'       => '0',
                    'op_is_cover_letter_required' => '1',
                    'op_other_jobs'               => '',
                    'op_pref_hourly_rate_max'     => '',
                    'op_high_hourly_rate_all'     => '0',
                    'op_cny_upm_verified'         => '0',
                    'op_pref_fb_score'            => '',
                    'engagement_weeks'            => '',
                    'job_category_level_one'      => '',
                    'ciphertext'                  => '~01039681e7c1af5488',
                    'op_pref_odesk_hours'         => '100',
                    'assignments'                 => '',
                    'ui_opening_status'           => 'Active',
                    'op_pref_location'            => 'Asia',
                    'buyer'                       => [
                        'op_tot_jobs_open'   => '1',
                        'op_tot_charge'      => '0',
                        'op_timezone'        => 'UTC+05:30 Mumbai, Kolkata, Chennai, New Delhi',
                        'op_contract_date'   => 'March 20, 2017',
                        'op_tot_jobs_posted' => '3',
                        'op_tot_asgs'        => '0',
                        'op_adjusted_score'  => '0',
                        'op_tot_hours'       => '0',
                        'op_tot_fp_asgs'     => '0',
                        'op_country'         => 'India',
                        'op_tot_jobs_filled' => '0',
                    ],
                    'candidates'                  => [
                        'candidate' => [
                            0 => [
                                'create_date_ts' => '1550555496',
                                'ciphertext'     => '~010d7a422e3567ddc5',
                            ],
                            1 => [
                                'create_date_ts' => '1550555286',
                                'ciphertext'     => '~0124c46b03fd1b360d',
                            ],
                        ],
                    ],
                    'op_tot_intv'                 => '1',
                    'op_tot_cand'                 => '3',
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
                ],
                'extra'        => null
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
