<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMNumberingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('M_Numbering', function (Blueprint $table) {
            $table->id();

            $table->integer('tenant_id');
            $table->char('tenant_name');
            $table->char('tenantBranch_name');

            $table->integer('numberdiv');
            $table->char('initNumber')->nullable();// 最新の採番後の番号（カウントIDとリング）
            $table->integer('countNumber')->nullable();
            $table->char('symbol', 3)->nullable();
            $table->integer('editdiv');
            $table->integer('datediv');
            
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
        Schema::dropIfExists('M_Numbering');
    }
}
