<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class addNullableCarfareEtc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_offers', function (Blueprint $table) {
            $table->string('carfare_1', 100)->nullable(true)->change();
            $table->string('carfare_payment_1', 100)->nullable(true)->change();
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
            $table->string('carfare_1', 100)->nullable(false)->change();
            $table->string('carfare_payment_1', 100)->nullable(false)->change();
        });
    }
}
