<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('products', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('pid')->unique();

            $table->string('id_view');
            $table->string('name')->nullable()->default(null);

            $table->foreignId('model_id')->constrained('pmodels');
            $table->string('model_name')->nullable()->default(null);

            $table->string('brand_id')->nullable()->default(null);
//            $table->foreign('brand_id')->references('pid')->on('brands');

            $table->string('color_id')->nullable()->default(null);
//            $table->foreign('color_id')->references('pid')->on('colors');

            $table->foreignId('shade_id')->nullable();

            $table->string('size_id')->nullable()->default(null);
//            $table->foreign('size_id')->references('pid')->on('sizes');

            $table->decimal('price')->nullable()->default(null);
            $table->decimal('pricePromobox')->nullable()->default(null);

            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
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