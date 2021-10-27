<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {

            $table->string('name');
            $table->unsignedBigInteger('cart_id')->nullable();
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');

            $table->unsignedBigInteger('inventory_id')->nullable();
            $table->foreign('inventory_id')->references('id')->on('inventories')->onDelete('cascade');

            $table->unsignedBigInteger('quantity');
            $table->decimal('price', 13, 2); // for each item
            $table->decimal('final_price', 13, 2); // for each item
            $table->decimal('discount', 13, 2)->nullable(); // for each item
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->timestamps();
            $table->primary(['cart_id', 'inventory_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
}
