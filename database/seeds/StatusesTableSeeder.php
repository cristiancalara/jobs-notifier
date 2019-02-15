<?php

use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert([[
            'label' => 'Not interested',
            'key'   => snake_case('Not interested')
        ], [
            'label' => 'Not sure',
            'key'   => snake_case('Not sure')
        ], [
            'label' => 'Interested',
            'key'   => snake_case('Interested')
        ], [
            'label' => 'Added bid',
            'key'   => snake_case('Added bid')
        ]]);
    }
}
