<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('pmodels', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->index();
            $table->string('name')->primary();
            $table->text('description')->nullable()->default(null);
            $table->string('image')->nullable()->default(null);
            $table->string('imageWebP')->nullable()->default(null);
            $table->string('imageGif')->nullable()->default(null);
            $table->string('imageHover')->nullable()->default(null);
            $table->string('groupWeb1')->nullable()->default(null);
//            $table->foreign('groupWeb1')->references('pid')->on('groups');
            $table->string('groupWeb2')->nullable()->default(null);
//            $table->foreign('groupWeb2')->references('pid')->on('groups');
            $table->string('groupWeb3')->nullable()->default(null);
//            $table->foreign('groupWeb3')->references('pid')->on('groups');
            $table->integer('statusNew')->nullable()->default(null);
            $table->decimal('minPrice')->nullable()->default(null);
            $table->integer('sort')->nullable()->default(null);
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
        Schema::dropIfExists('models');
    }
}