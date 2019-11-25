<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraws', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_number')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('username')->nullable();
            $table->decimal('amount', 16, 2)->default(0);
            $table->decimal('bonus', 16, 2)->default(0);
            $table->decimal('counter_fee', 16, 2)->default(0);
            $table->tinyInteger('payment_type')->default(1);
            $table->bigInteger('bank_account_id')->nullable();
            $table->string('payment_desc')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_card')->nullable();
            $table->string('bank_address')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->text('fail_reason')->nullable();
            $table->timestamp('hk_at')->nullable();
            $table->timestamp('confirm_at')->nullable();
            $table->integer('admin_id')->nullable();
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
        Schema::dropIfExists('withdraws');
    }
}
