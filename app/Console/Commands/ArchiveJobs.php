<?php

namespace App\Console\Commands;

use App\Job;
use App\Upwork\Importer;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ArchiveJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs-notifier:archive-jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Archive jobs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws \Upwork\API\ApiException
     */
    public function handle()
    {
        $limit = new Carbon('1 month ago');

        Job::chunkById(10, function ($jobs) use ($limit) {
            $jobsToArchive = collect([]);
            /** @var Job $job */
            foreach ($jobs as $job) {
                if ($job->date_created->lt($limit)) {
                    $jobsToArchive[] = (array)DB::table('jobs')->where('id', $job->id)->first();
                }
            }

            DB::transaction(function () use ($jobsToArchive) {
                DB::table('archived_jobs')->insert($jobsToArchive->toArray());
                DB::table('jobs')->whereIn('id', $jobsToArchive->pluck('id'))->delete();
            });
        });
    }
}
