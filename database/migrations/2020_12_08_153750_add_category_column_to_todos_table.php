<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryColumnToTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->unsignedTinyInteger('cate')->default(1)->comment('分类 1 计划,2 日常')->index()->after('status');
            $table->unsignedInteger('operator_user_id')->default(0)->comment('完成人')->index()->after('user_id');
        });

        \Illuminate\Support\Facades\DB::update('UPDATE todos SET operator_user_id = user_id WHERE `status` =1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->dropColumn('cate');
            $table->dropColumn('operator_user_id');
        });
    }
}
