<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('sku');
            $table->string('description');
            $table->string('body');
            $table->json('related_products');
            $table->unsignedTinyInteger('tax_status')->default(0); // 0 means contains no tax
            $table->unsignedTinyInteger('virtual')->default(0); // 0 means it's not a virtual product
            $table->unsignedTinyInteger('downloadable')->default(0); // 0 means it's not downloadable
            $table->unsignedTinyInteger('publish')->default(0); // 0 means it is not published yet

            $table->unsignedBigInteger('quantity');
            $table->unsignedBigInteger('min_quantity');
            $table->unsignedDecimal('price', 15, 2);
            $table->unsignedDecimal('final_price', 15, 2);
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
        Schema::dropIfExists('products');
    }
}
