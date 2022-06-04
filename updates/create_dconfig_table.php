<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDconfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('llconfig', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('变量名')->unique();
            $table->tinyInteger('type')->default(0)->comment('类型');
            $table->string('value')->comment('键值')->nullable();
            $table->text('option')->comment('选项:select,radio等选择类型的数据')->nullable();
            $table->text('description')->comment('说明')->nullable();
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
        Schema::dropIfExists('llconfig');
    }
}
