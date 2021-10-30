<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

          

            $table->string('name');
            $table->unsignedInteger('quantity');

            //when data store with model => inventory
            $table->string('subject_id');
            $table->string('subject_type');



            // when  doesn't have  model 
            $table->unsignedBigInteger('inventory_id')->nullable();
            $table->foreign('inventory_id')->references('id')->on('inventories')->onDelete('cascade');
            $table->decimal('price', 13, 2)->nullable(); // for each item
            $table->decimal('final_price', 13, 2)->nullable(); // for each item
            $table->decimal('discount', 13, 2)->nullable(); // for each item
            $table->string('tax')->nullable(); // for each item
            $table->string('color')->nullable();
            $table->string('size')->nullable();


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
        Schema::dropIfExists('carts');
    }
}
