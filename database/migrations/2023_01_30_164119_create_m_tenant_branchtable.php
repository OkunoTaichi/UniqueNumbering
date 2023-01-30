<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMTenantBranchtable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('M_TenantBranchtable', function (Blueprint $table) {
            $table->id();
            $table->char('TenantCode');
            $table->char('TenantBranch');
            $table->char('TenantBranchName');
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
        Schema::dropIfExists('M_TenantBranchtable');
    }
}
