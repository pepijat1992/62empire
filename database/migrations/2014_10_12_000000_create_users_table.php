<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
            $table->bigIncrements('id');
            $table->string('username')->unique()->nullable();
            $table->string('name')->nullable();
            $table->string('phone_number')->unique();
            $table->string('password')->nullable();
            $table->decimal('score', 16, 2)->default(0);
            $table->bigInteger('agent_id')->nullable();
            $table->string('register_ip')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->dateTime('last_login_at')->nullable();
            $table->text('description')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
