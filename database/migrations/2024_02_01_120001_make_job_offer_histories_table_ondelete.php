<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeJobOfferHistoriesTableOndelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_offer_histories', function (Blueprint $table) {
            $table->dropForeign(['job_offer_id']);
            $table->dropForeign(['user_id']);
            $table->foreign('job_offer_id')->references('id')->on('job_offers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_offer_histories', function (Blueprint $table) {
            $table->dropForeign(['job_offer_id']);
            $table->dropForeign(['user_id']);
            $table->foreign('job_offer_id')->references('id')->on('job_offers');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
}
