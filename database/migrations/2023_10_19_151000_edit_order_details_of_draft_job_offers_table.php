<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditOrderDetailsOfDraftJobOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('draft_job_offers', function (Blueprint $table) {
            $table->string('order_details', 10000)->comment('発注業務詳細')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('draft_job_offers', function (Blueprint $table) {
            $table->string('order_details', 100)->comment('発注業務詳細')->change();
        });
    }
}
