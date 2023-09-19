<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJobOffersChangeInsuranceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_offers', function (Blueprint $table) {
            $table->string('employment_insurance_2', 100)->comment('雇用保険加入②')->nullable(true)->change();//
            $table->string('social_insurance_2', 100)->comment('社会保険加入②')->nullable(true)->change();//
            $table->string('employment_insurance_3', 100)->comment('雇用保険加入③')->nullable(true)->change();//
            $table->string('social_insurance_3', 100)->comment('社会保険加入③')->nullable(true)->change();//
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_offers', function (Blueprint $table) {
            $table->string('employment_insurance_2', 100)->comment('雇用保険加入②')->nullable(false)->change();//
            $table->string('social_insurance_2', 100)->comment('社会保険加入②')->nullable(false)->change();//
            $table->string('employment_insurance_3', 100)->comment('雇用保険加入③')->nullable(false)->change();//
            $table->string('social_insurance_3', 100)->comment('社会保険加入③')->nullable(false)->change();//
        });
    }
}
