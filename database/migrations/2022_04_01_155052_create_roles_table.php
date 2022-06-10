<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('役職名');  // ロール名
            $table->string('memo')->comment('備考');  // 備考
            $table->timestamps();
        });
        DB::table('roles')->insert(['id'=>1,'name'=>'management','memo'=>'管理職']);
        DB::table('roles')->insert(['id'=>2,'name'=>'General_employee','memo'=>'一般社員']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
