<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExpiryForUserCertificates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function (Blueprint $table) {
            $table->date('expiry_mand_traning')->after('mand_training')->nullable();
            $table->date('expiry_cert_of_crbdbs')->after('cert_of_crbdbs')->nullable();
            $table->date('expiry_passport_visa')->after('passport_visa')->nullable();
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('expiry_mand_traning');
            $table->dropColumn('expiry_cert_of_crbdbs');
            $table->dropColumn('expiry_passport_visa');
        });
    }
}
