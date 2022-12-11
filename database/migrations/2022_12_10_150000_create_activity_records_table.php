<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_records', function (Blueprint $table) {
            $table->id();
            $table->date('date')->comment('日付')->nullable();
            $table->string('item')->comment('項目（1:求人情報更新/編集, 2:掲載完了, 3:再掲載, 4:非公開, 5:その他）')->nullable();
            $table->text('detail')->comment('詳細')->nullable();
            $table->bigInteger('job_offer_id')->unsigned()->comment('求人情報ID');
            $table->foreign('job_offer_id')->references('id')->on('job_offers');
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
        Schema::dropIfExists('activity_records');
    }
}
