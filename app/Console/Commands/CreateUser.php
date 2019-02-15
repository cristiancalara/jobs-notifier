<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs-notifier:create-user {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create user';

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
        $user            = new User;
        $user->email     = $this->argument('email');
        $user->password  = Hash::make($this->argument('password'));
        $user->api_token = str_random(60);

        $user->save();

        $this->table(['Id', 'Email', 'Password'], [
            [
                'id'       => $user->id,
                'email'    => $this->argument('email'),
                'password' => $this->argument('password')
            ]
        ]);
    }
}
