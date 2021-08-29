<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->decimal('amount', 10, 2);
            $table->decimal('maxDiscount', 10, 2);
            $table->decimal('minPrice', 11, 2);
            $table->string('measure');
            $table->text('description')->nullable();
            $table->boolean('limit')->default();
            $table->string('type');
            $table->json('data'); // data can be array of categories or products or users
            $table->dateTime('beginning');
            $table->dateTime('expriration');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discounts');
    }
}
