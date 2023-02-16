<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('clients', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('client_name');
        //     $table->integer('client_id');//採番前の番号
        //     $table->integer('tenant_id');//テナントコード
        

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
        Schema::dropIfExists('clients');
    }
}
