<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('element_id');
            $table->foreign('element_id')->references('id')->on('elements')->onDelete('cascade');
            $table->string('buttonLabel')->nullable();
            $table->string('buttonLink')->nullable();
            $table->string('customClass')->nullable();
            $table->unsignedTinyInteger('cols')->nullable();
            $table->string('description')->nullable();
            $table->string('link')->nullable();
            $table->unsignedInteger('order')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('time')->nullable();
            $table->string('title')->nullable();
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
        Schema::dropIfExists('contents');
    }
}
