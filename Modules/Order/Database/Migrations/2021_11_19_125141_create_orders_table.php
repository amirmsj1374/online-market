<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('item_count'); //تعداد آیتم ها
            $table->tinyInteger('is_pay')->default(0); //وضعیت پرداخت
            $table->enum('status', ['preparation', 'posted', 'received', 'canceled']); //وضعیت سفارش
            $table->decimal('final_price', 11, 2); //قیمت کل
            $table->string('payment_method');
            $table->string('payment_id')->nullable(); //شناسه پرداخت
            $table->enum('post_type', ['tipbox', 'central_post'])->default('central_post'); //نوع ارسال مرسوله
            $table->string('post_pay')->nullable(); //هزینه پست
            $table->string('tracking_serial')->nullable(); //کد رهگیری پستی
            $table->text('note')->nullable(); //قسمت اطلاع رسانی پروفایل کاربر
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
        Schema::dropIfExists('orders');
    }
}
