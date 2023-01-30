<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('product_id');
            $table->foreign('product_id')->references('pid')->on('products');

            $table->string('image_number');
            $table->string('pid_inb')->unique();
            $table->string('image')->nullable()->default(null);
            $table->string('imageWebp')->nullable()->default(null);
            $table->string('imageGif')->nullable()->default(null);
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
        Schema::dropIfExists('images');
    }
}