<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobProfessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_profession', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id')->unsigned();
            $table->integer('profession_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('job_profession', function (Blueprint $table) {
            $table->foreign('job_id')
                ->references('id')
                ->on('jobs');

            $table->foreign('profession_id')
                ->references('id')
                ->on('professions');

        });

        DB::table('jobs')->truncate();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_profession');
    }
}
