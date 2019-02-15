<?php

namespace App\Console\Commands;

use App\Upwork\Client;
use App\User;
use Illuminate\Console\Command;

class GetAccessToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs-notifier:get-access-token {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Requests and sets the upwork access token';

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
     * Execute the console command.
     *
     * @return mixed
     * @throws \Upwork\API\ApiException
     */
    public function handle()
    {
        $userId = $this->argument('user');

        /** @var User $user */
        $user = User::findOrFail($userId);

        // Get token.
        $info = (new Client())->auth();

        // Save to db.
        $user->access_token  = $info['access_token'];
        $user->access_secret = $info['access_secret'];
        $user->save();

        $this->line("Saved access token and secret for user: {$user->email}");
    }
}
