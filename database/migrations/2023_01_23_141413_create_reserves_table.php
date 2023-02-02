<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('reserves', function (Blueprint $table) {
        //     $table->id();
        //     $table->char('number_name');//任意で付けた予約名称
        //     $table->char('reserve_id');//採番後の番号
        //     $table->integer('client_id');//採番前の番号
        //     $table->char('client_name');//予約者氏名
        //     $table->char('tenant_id');//会社＋施設コード（仮）
        //     $table->timestamps();
        //     $table->softDeletes();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reserves');
    }
}
