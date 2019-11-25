<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_number')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('username')->nullable();
            $table->decimal('amount', 16, 2)->default(0);
            $table->decimal('bonus', 16, 2)->default(0);
            $table->integer('promotion_id')->nullable();
            $table->decimal('promotion_amount', 16, 2)->default(0);
            $table->tinyInteger('payment_type')->default(1);
            $table->bigInteger('bank_account_id')->nullable();
            $table->string('payment_desc')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->text('fail_reason')->nullable();
            $table->timestamp('hk_at')->nullable();
            $table->timestamp('confirm_at')->nullable();
            $table->integer('admin_id')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('deposits');
    }
}
