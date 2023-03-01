<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('pid')->unique();
            $table->text('name')->nullable();
            $table->text('slug')->nullable();
            $table->string('sort')->nullable()->default(null);
            $table->string('parent')->nullable()->default(null);
            $table->string('multitree')->nullable()->default(null);
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
        Schema::dropIfExists('groups');
    }
}