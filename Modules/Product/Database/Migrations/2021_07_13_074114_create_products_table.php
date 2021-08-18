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
            $table->string('sku')->nullable();
            $table->string('description');
            $table->text('body')->nullable();
            $table->json('related_products')->nullable();
            $table->unsignedTinyInteger('tax_status')->default(0); // 0 means contains no tax
            $table->unsignedTinyInteger('virtual')->default(0); // 0 means it's not a virtual product
            $table->unsignedTinyInteger('downloadable')->default(0); // 0 means it's not downloadable
            $table->unsignedTinyInteger('publish')->default(0); // 0 means it is not published yet

            $table->unsignedBigInteger('quantity')->nullable();
            $table->unsignedBigInteger('min_quantity')->nullable();
            $table->unsignedDecimal('price', 15, 2)->nullable();
            $table->unsignedDecimal('final_price', 15, 2)->nullable();


            //transport part
            $table->integer('length')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();

            $table->text('imagesUrl')->nullable();

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
