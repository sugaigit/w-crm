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
            // $table->bigInteger('user_id')->unsigned()->nullable()->comment('営業担当');
            // $table->foreign('user_id')->references('id')->on('users');
            $table->string('company_type')->comment('取扱会社種別（1:HA, 2:HC）');
            $table->string('handling_office')->comment('取扱事業所名（1:北九州本社）, 2:福岡支店');
            $table->string('name')->comment('クライアント名');
            $table->string('kana')->nullable()->comment('クライアントカナ');
            $table->string('address')->comment('住所');
            $table->string('phone')->comment('電話番号');
            $table->string('fax')->nullable()->comment('FAX');
            $table->string('company_rank')->nullable()->comment('企業ランク');
            $table->timestamps();
        });
        DB::table('customers')->insert([
            'id' => 1,
            'company_type' => '1',
            'handling_office' => '1',
            'name' => '田中商店 ',
            'kana' => 'タナカショウテン',
            'address' => '福岡県某所',
            'phone' => '000-1111-2222',
            'fax' => '001-1111-2222',
            'company_rank' => 'A',
        ]);
        DB::table('customers')->insert([
            'id' => 2,
            'company_type' => '2',
            'handling_office' => '2',
            'name' => '井上貿易 ',
            'kana' => 'イノウエボウエキ',
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
