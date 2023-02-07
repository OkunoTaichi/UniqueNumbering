<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDivEditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('EditDiv', function (Blueprint $table) {
        //     $table->id();
        //     $table->integer('edit_id')->unique();
        //     $table->char('edit_name');
        //     $table->integer('edit_length');
        //     $table->text('memo');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('EditDiv');
    }
}
