<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAppoSlotTimesAndAdmCatchTimeToJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->string('job_appo_slot_times')->default('');
            $table->string('job_adm_catch_time')->default('');
            $table->string('job_adm_catch_time_interval')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn('job_appo_slot_times');
            $table->dropColumn('job_adm_catch_time');
            $table->dropColumn('job_adm_catch_time_interval');
        });
    }
}
