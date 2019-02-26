<?php

namespace App\Console\Commands;


use App\Job;
use App\Status;
use App\Upwork\Importer;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;


class CleanupJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs-notifier:cleanup-jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark poor rated jobs as not interested after 2 days pass.';

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
     */
    public function handle()
    {
        $oneDayAgo     = new Carbon('1 day ago');
        $notInterested = Status::where('key', 'not_interested')->first();

        Job::chunkById(200, function ($jobs) use ($oneDayAgo, $notInterested) {
            $ids = [];
            /** @var Job $job */
            foreach ($jobs as $job) {
                if (
                    $job->date_created->lt($oneDayAgo) &&
                    $job->rating < 70
                ) {
                    $ids[] = $job->id;
                }
            }

            DB::table('jobs')->whereIn('id', $ids)->update(['status_id' => $notInterested->id]);
        });
    }
}