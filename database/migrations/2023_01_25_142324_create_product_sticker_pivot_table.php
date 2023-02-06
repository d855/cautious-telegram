<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateProductStickerPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_stickers', function (Blueprint $table) {
            $table->string('product_id')->index();
            $table->unsignedBigInteger('sticker_id')->index();
            $table->timestamps();
            $table->primary(['product_id', 'sticker_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_sticker');
    }
}