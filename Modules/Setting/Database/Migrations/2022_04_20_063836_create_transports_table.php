<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transports', function (Blueprint $table) {
            $table->id();
            $table->decimal('inside_500g', 10, 2);
            $table->decimal('edge_500g', 10, 2);
            $table->decimal('inside_1000g', 10, 2);
            $table->decimal('outside_1000g', 10, 2);
            $table->decimal('inside_2000g', 10, 2);
            $table->decimal('outside_2000g', 10, 2);
            $table->decimal('higher_2000g', 10, 2);
            $table->decimal('insurance', 10, 2);
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
        Schema::dropIfExists('transports');
    }
}
