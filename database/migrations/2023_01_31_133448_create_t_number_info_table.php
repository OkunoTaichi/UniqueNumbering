<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTNumberInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_number_info', function (Blueprint $table) {
            $table->id();

            $table->char('TenantCode');
            $table->integer('TenantBranch');

            $table->integer('NumberDiv');
            $table->integer('NumberDate');

            $table->char('No');// 最新の採番後の番号（カウントIDとリング）
            $table->integer('CountNumber');

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
        Schema::dropIfExists('t_number_info');
    }
}
