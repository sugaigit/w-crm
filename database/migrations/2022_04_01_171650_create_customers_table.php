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
            $table->string('company_id');//取扱会社種別
            $table->string('handling_office');//取扱事業所
            $table->string('client_name');//クライアント名
            $table->string('client_name_kana');//クライアント名　カナ
            $table->string('postal');//郵便番号
            $table->string('prefectures');//都道府県
            $table->string('municipalities');//市区町村
            $table->string('streetbunch');//町名番地
            $table->string('phone');//電話番号
            $table->string('fax');//FAX
            $table->string('website');//WEBサイト
            $table->string('industry');//業種
            $table->string('remarks');//備考
            $table->string('inflowroute');//流入経路
            $table->string('navi_no');//Navi No
            $table->date('established');//設立
            $table->string('deadline');//締日
            $table->string('invoicemustarrivedate');//請求書必着日
            $table->string('paymentdate');//支払い日
            $table->string('company_rank');//企業ランク
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
