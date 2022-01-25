<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('board_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->integer('order')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->engine = "InnoDB";
            $table->timestamps();

            $table->foreign('board_id')->references("id")->on("boards")->onDelete('cascade');
            $table->foreign('user_id')->references("id")->on("users")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
