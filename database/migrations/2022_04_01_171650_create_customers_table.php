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
            $table->string('handling_type')->comment('取扱会社種別（1:HA, 2:HC）');
            $table->string('handling_office')->comment('取扱事業所名（1:北九州本社, 2:福岡支店）');
            $table->string('corporate_type')->comment('法人形態（1:前株, 2:後株, 3:合同会社, 4:有限責任事業組合（LLP）, 5:有限会社）');
            $table->string('customer_name')->comment('顧客名');
            $table->string('customer_kana')->nullable()->comment('顧客名（カナ）');
            $table->string('address')->comment('住所');
            $table->string('phone')->comment('電話番号');
            $table->string('fax')->nullable()->comment('FAX');
            $table->string('company_rank')->nullable()->comment('企業ランク'); // 現状は未使用。いずれ利用する可能性あり。
            $table->timestamps();
        });
        DB::table('customers')->insert([
            'id' => 1,
            'handling_type' => '1',
            'handling_office' => '1',
            'customer_name' => '田中商店 ',
            'customer_kana' => 'タナカショウテン',
            'address' => '福岡県某所',
            'phone' => '000-1111-2222',
            'fax' => '001-1111-2222',
            'company_rank' => 'A',
        ]);
        DB::table('customers')->insert([
            'id' => 2,
            'handling_type' => '2',
            'handling_office' => '2',
            'customer_name' => '井上貿易 ',
            'customer_kana' => 'イノウエボウエキ',
            'address' => '熊本県某所',
            'phone' => '999-1111-2222',
            'fax' => '998-1111-2222',
            'company_rank' => 'B',
        ]);

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
