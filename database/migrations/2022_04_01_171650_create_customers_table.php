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
            $table->string('corporate_type')->comment('法人形態（1:前株, 2:後株, 3:合同会社, 4:有限会社, 5:なし, 6:その他）');
            $table->string('customer_name')->comment('顧客名');
            $table->string('customer_kana')->nullable()->comment('顧客名（カナ）');
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
        // DB::table('customers')->insert([
        //     'id' => 1,
        //     'user_id' => 1,
        //     'handling_type' => '1',
        //     'handling_office' => '1',
        //     'customer_name' => '田中商店 ',
        //     'customer_kana' => 'タナカショウテン',
        //     'address' => '福岡県某所',
        //     'phone' => '000-1111-2222',
        //     'fax' => '001-1111-2222',
        //     'company_rank' => 'A',
        // ]);
        // DB::table('customers')->insert([
        //     'id' => 2,
        //     'user_id' => 2,
        //     'handling_type' => '2',
        //     'handling_office' => '2',
        //     'customer_name' => '井上貿易 ',
        //     'customer_kana' => 'イノウエボウエキ',
        //     'address' => '熊本県某所',
        //     'phone' => '999-1111-2222',
        //     'fax' => '998-1111-2222',
        //     'company_rank' => 'B',
        // ]);

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
