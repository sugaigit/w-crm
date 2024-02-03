<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeActivityRecordsTableOndelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activity_records', function (Blueprint $table) {
            $table->dropForeign(['job_offer_id']);
            $table->foreign('job_offer_id')->references('id')->on('job_offers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activity_records', function (Blueprint $table) {
            $table->dropForeign(['job_offer_id']);
            $table->foreign('job_offer_id')->references('id')->on('job_offers');
        });
    }
}
