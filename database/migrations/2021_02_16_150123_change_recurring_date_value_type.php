<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeRecurringDateValueType extends Migration
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
            $table->timestamp('recurring_date_value')->after('recurring_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
