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
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('jobs');
            $table->rememberToken();
            $table->timestamps();
        });
        DB::table('users')->insert(['id' => 1, 'name' => '小林珠美', 'email' => 'sute1@example.com', 'password' => bcrypt('password'), 'jobs' => '一般社員']);
        DB::table('users')->insert(['id' => 2, 'name' => '岸辺露伴', 'email' => 'sute2@example.com', 'password' => bcrypt('password'), 'jobs' => '管理職']);
        DB::table('users')->insert(['id' => 3, 'name' => '広瀬康一', 'email' => 'sute3@example.com', 'password' => bcrypt('password'), 'jobs' => '管理職']);
        DB::table('users')->insert(['id' => 4, 'name' => '吉良吉影', 'email' => 'sute4@example.com', 'password' => bcrypt('password'), 'jobs' => '一般社員']);

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
