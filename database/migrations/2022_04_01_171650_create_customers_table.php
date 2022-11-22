<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->comment('営業担当');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('company_type')->unique()->comment('取扱会社種別');
            $table->string('handling_office')->unique()->comment('取扱事業所名');
            $table->string('name')->unique()->comment('クライアント名');
            $table->string('kana')->comment('クライアントカナ');
            $table->string('address')->comment('住所');
            $table->string('phone')->comment('電話番号');
            $table->string('fax')->comment('FAX');
            $table->string('company_rank')->comment('企業ランク');
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
        Schema::dropIfExists('customers');
    }
}
