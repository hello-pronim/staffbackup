<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameRecurringDateValueToRecurringEndDateInCalendarEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calendar_events', function(Blueprint $table){
            $table->dropColumn('recurring_date_value');
        });

        Schema::table('calendar_events', function(Blueprint $table){
            $table->date('recurring_end_date')->after('recurring_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
