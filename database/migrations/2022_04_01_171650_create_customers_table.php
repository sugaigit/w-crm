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
            $table->bigInteger('user_id')->unsigned()->comment('作成者');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('handling_type')->comment('取扱会社種別（1:HA, 2:HC）');
            $table->string('handling_office')->comment('取扱事業所名（1:北九州本社, 2:福岡支店）');
            $table->string('corporate_type')->comment('法人形態（1:（前）株式会社, 2:（後）株式会社, 3:（前）合同会社, 4:（後）合同会社, 5:（前）有限会社, 6:（後）有限会社, 7:なし, 8:その他）');
            $table->string('customer_name')->comment('顧客名');
            $table->string('customer_kana')->nullable()->comment('顧客名（カナ）');
            $table->string('industry')->nullable()->comment('業種');
            //企業ランク
            $table->string('company_size')->nullable()->comment('会社規模');
            $table->string('business_development_area')->nullable()->comment('事業展開地域');
            $table->string('business_expansion_potential')->nullable()->comment('取引拡大の可能性');
            $table->string('company_history')->nullable()->comment('社歴');
            $table->string('realiabillty')->nullable()->comment('信頼性');
            $table->string('department')->nullable()->comment('所属部署');
            $table->string('manager_name')->nullable()->comment('顧客担当者名');
            $table->string('address')->comment('顧客住所');
            $table->string('phone')->comment('電話番号');
            $table->string('email')->comment('メールアドレス');
            $table->string('fax')->nullable()->comment('FAX');
            $table->string('company_rank')->nullable()->comment('企業ランク'); // 現状は未使用。いずれ利用する可能性あり。
            $table->timestamps();
            $table->boolean('hidden')->comment('0表示・1非表示');
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
