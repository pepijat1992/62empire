<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->string('sub_title')->nullable();
            $table->integer('rate')->nullable();
            $table->integer('amount')->nullable();
            $table->string('image_en')->nullable();
            $table->string('image_malaya')->nullable();
            $table->string('image_zh_cn')->nullable();
            $table->text('title_content')->nullable();
            $table->text('content')->nullable();
            $table->date('start_at')->nullable();
            $table->date('end_at')->nullable();
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
        Schema::dropIfExists('promotions');
    }
}
