<?php

namespace App\Console\Commands;


use App\Upwork\Importer;
use App\User;
use Illuminate\Console\Command;


class ImportJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs-notifier:import-jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import jobs';

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
        $users = User::all();
        foreach ($users as $user) {
            (new Importer($user))->import();
        }
    }
}
