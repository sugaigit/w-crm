<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('氏名');
            $table->string('email')->unique()->comment('メールアドレス');
            $table->string('password')->comment('パスワード');
            $table->string('role')->comment('役職');
            $table->rememberToken();
            $table->timestamps();
        });
        // DB::table('users')->insert(['id' => 1, 'name' => '山田太郎', 'email' => 'test1@example.com', 'password' => bcrypt('secret'), 'role' => '一般']);
        // DB::table('users')->insert(['id' => 2, 'name' => '畠山俊二', 'email' => 'test2@example.com', 'password' => bcrypt('secret'), 'role' => '部長']);
        DB::table('users')->insert(['id' => 1, 'name' => 'テストユーザー', 'email' => 'test@example.com', 'password' => bcrypt('secret'), 'role' => '部長']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
