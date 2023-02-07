<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMDivisionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_division', function (Blueprint $table) {
            $table->char('DivCode');
            $table->integer('DivNo');
            $table->char('DivName');
            $table->boolean('Value1')->nullable();
            $table->boolean('Value2')->nullable();
            $table->boolean('Value3')->nullable();
            $table->boolean('Value4')->nullable();
            $table->boolean('Value5')->nullable();
            $table->boolean('Value6')->nullable();
            $table->boolean('Value7')->nullable();
            $table->boolean('Value8')->nullable();
            $table->boolean('Value9')->nullable();
            $table->boolean('Value10')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_division');
    }
}
