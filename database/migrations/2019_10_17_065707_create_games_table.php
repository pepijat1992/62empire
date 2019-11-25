<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->string('domain')->nullable();
            $table->string('link_android')->nullable();
            $table->string('link_iphone')->nullable();
            $table->string('android_run')->nullable();
            $table->string('iphone_run')->nullable();
            $table->string('agent')->nullable();
            $table->string('api_key')->nullable();
            $table->string('token')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->decimal('money', 16, 2)->default(0);
            $table->tinyInteger('is_demo')->nullable();
            $table->string('prefix')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->tinyInteger('sort')->nullable();
            $table->string('play_type')->nullable();
            $table->string('type')->nullable();
            $table->string('image')->nullable();
            $table->string('image1')->nullable();
            $table->string('image2')->nullable();
            $table->integer('order')->nullable();
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
        Schema::dropIfExists('games');
    }
}
