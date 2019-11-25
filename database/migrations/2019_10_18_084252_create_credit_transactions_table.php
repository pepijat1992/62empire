<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sender_id')->nullable();
            $table->bigInteger('receiver_id')->nullable();
            $table->string('sender_role')->nullable();
            $table->string('receiver_role')->nullable();
            $table->decimal('amount', 16, 2)->default(0);
            $table->decimal('before_score', 16, 2)->nullable();
            $table->decimal('after_score', 16, 2)->nullable();
            $table->string('type')->nullable();
            $table->text('description')->nullable();
            $table->string('ip')->nullable();
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
        Schema::dropIfExists('credit_transactions');
    }
}
