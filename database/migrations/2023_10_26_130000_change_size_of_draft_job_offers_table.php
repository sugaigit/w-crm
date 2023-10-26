<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSizeOfDraftJobOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('draft_job_offers', function (Blueprint $table) {
            $table->string('company_address', 200)->change();
            $table->string('company_others', 200)->change();
            $table->text('bonuses_treatment')->change();
            $table->text('holidays_vacations')->change();
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
            $table->string('company_address', 100)->change();
            $table->string('company_others', 100)->change();
            $table->string('bonuses_treatment', 255)->change();
            $table->string('holidays_vacations', 255)->change();
        });
    }
}
