<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChildrenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('children', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number')->nullable();
            $table->string('holy_name', 100)->nullable();
            $table->string('name', 100)->nullable();
            $table->unsignedInteger('group_id')->nullable();
            $table->dateTime('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('baptism')->nullable();
            $table->boolean('holy_eucharist')->nullable();
            $table->boolean('confirmation')->nullable();
            $table->string('father')->nullable();
            $table->string('mother')->nullable();
            $table->string('address')->nullable();
            $table->string('parish')->nullable();
            $table->string('diocese')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('children');
    }
}
