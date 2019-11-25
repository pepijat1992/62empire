<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->nullable();
            $table->string('player')->nullable();
            $table->bigInteger('agent_id')->nullable();
            $table->integer('game_id')->nullable();
            $table->bigInteger('game_account_id')->nullable();
            $table->string('username')->nullable();
            $table->date('bet_date')->nullable();
            $table->decimal('win_lose_amount', 16, 2)->default(0);
            $table->integer('status')->default(0);
            $table->string('currency')->nullable();
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
        Schema::dropIfExists('game_records');
    }
}
