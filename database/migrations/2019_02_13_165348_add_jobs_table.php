<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('status_id')->unsigned()->nullable();
            $table->string('api_id');
            $table->string('title');
            $table->text('snippet')->nullable();
            $table->string('category2');
            $table->string('subcategory2')->nullable();
            $table->json('skills');
            $table->string('job_type');
            $table->integer('budget')->unsigned()->nullable();
            $table->string('duration')->nullable();
            $table->string('workload')->nullable();
            $table->string('job_status');
            $table->timestamp('date_created')->nullable();
            $table->string('url');
            $table->json('client')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
