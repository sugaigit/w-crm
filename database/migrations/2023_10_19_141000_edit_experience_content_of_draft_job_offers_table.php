<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditExperienceContentOfDraftJobOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('draft_job_offers', function (Blueprint $table) {
            $table->string('experience_content', 100)->comment('経験内容')->nullable()->change();
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
            $table->string('experience_content', 10)->comment('経験内容')->nullable()->change();
        });
    }
}
