<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('product_stocks', function (Blueprint $table) {
           // $table->unsignedBigInteger('id')->autoIncrement();

            $table->string('product_id');
           // $table->foreign('product_id')->references('pid')->on('products');

            $table->string('warehouse');
           // $table->string('date')->nullable();
            $table->integer('quantity')->nullable()->default(null);
            $table->primary(['product_id','warehouse']);
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
        Schema::dropIfExists('product_stock');
    }
}