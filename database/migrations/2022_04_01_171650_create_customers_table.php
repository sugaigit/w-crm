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
            $table->id();//固有ID
            $table->string('company_type');//取扱会社種別
            $table->string('handling_office');//取扱事業所
            $table->string('customer_type');//法人形態
            $table->string('name');//クライアント名
            $table->string('kana');//クライアント名　カナ
            $table->string('address');//住所
            $table->string('phone');//phone
            $table->string('fax');//FAX
            // $table->string('company_rank');//企業ランク
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
