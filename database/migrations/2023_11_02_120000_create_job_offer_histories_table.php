<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobOfferHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_offer_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('job_offer_id')->unsigned()->comment('求人情報');
            $table->foreign('job_offer_id')->references('id')->on('job_offers');         
            $table->bigInteger('user_id')->unsigned()->comment('編集者');
            $table->foreign('user_id')->references('id')->on('users');
            $table->json('updated_content')->comment('更新内容');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_offer_histories');
    }
}
