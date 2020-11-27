<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('标题');
            $table->unsignedInteger('user_id')->comment('用户id')->index();
            $table->string('desc')->comment('描述');
            $table->unsignedInteger('endTime')->default(0)->comment('完成时间')->index();
            $table->boolean('status')->default(false)->comment('完成状态');
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
        Schema::dropIfExists('todos');
    }
}
