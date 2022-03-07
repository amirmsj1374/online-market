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
            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');

            $table->text('body')->nullable();
            $table->string('buttonLabel')->nullable();
            $table->json('categories')->nullable();
            $table->string('customClass')->nullable();
            $table->unsignedTinyInteger('col')->nullable();
            $table->string('link')->nullable();
            $table->string('height')->nullable();
            $table->unsignedInteger('order')->nullable();
            $table->json('products')->nullable();
            $table->string('time')->nullable();
            $table->string('type')->nullable();
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
