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
            $table->decimal('maxDiscount', 10, 2)->nullable();
            $table->decimal('minPrice', 11, 2)->nullable();
            $table->string('measure');
            $table->text('description')->nullable();
            $table->boolean('limit')->default();
            $table->string('type');
            $table->json('selected')->nullable(); // data can be array of categories or products or users
            $table->dateTime('beginning');
            $table->dateTime('expiration');
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
