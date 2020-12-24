<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeStartEndFieldsForCalendarEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calendar_events', function(Blueprint $table){
            $table->dropColumn('start');
            $table->dropColumn('end');
        });

        Schema::table('calendar_events', function(Blueprint $table){
            $table->timestamp('start')->nullable();
            $table->timestamp('end')->nullable();
        });
    }

}
