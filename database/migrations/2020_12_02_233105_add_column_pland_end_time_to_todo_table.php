<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPlandEndTimeToTodoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('todos', function (Blueprint $table) {
            //
            $table->timestamp('plan_start_time')->nullable()->comment('计划开始时间');
            $table->timestamp('plan_end_time')->nullable()->comment('计划结束时间');
            $table->string('address')->nullable()->comment('地址');
            $table->string('longitude')->nullable()->comment('经度');
            $table->string('latitude')->nullable()->comment('纬度');
            $table->string('image')->nullable()->comment('图片');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('todo', function (Blueprint $table) {
            $table->dropColumn('plan_start_time');
            $table->dropColumn('plan_end_time');
            $table->dropColumn('address');
            $table->dropColumn('longitude');
            $table->dropColumn('latitude');
            $table->dropColumn('image');
        });
    }
}
