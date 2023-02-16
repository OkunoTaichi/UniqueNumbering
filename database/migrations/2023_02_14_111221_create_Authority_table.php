<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('M_Authority', function (Blueprint $table) {
            $table->char('TenantCode');
            $table->integer('TenantBranch');
            $table->integer('AuthorityCode');
            $table->char('AuthorityName');
            $table->boolean('AdminFlg')->nullable();
            $table->timestamps();
            $table->integer('UpdatePerson')->nullable();// ユーザーID とりあえず
        });
        Schema::create('M_AuthorityDetail', function (Blueprint $table) {

            // $table->id();
            $table->char('TenantCode');
            $table->integer('TenantBranch');
            $table->integer('AuthorityCode');
            $table->char('ProgramID');
            $table->integer('AuthorityDiv');
            $table->timestamps();
            $table->integer('UpdatePerson')->nullable();// ユーザーID とりあえず

            $table->primary(['TenantBranch','AuthorityCode', 'ProgramID']);
        });
        Schema::create('M_Program', function (Blueprint $table) {
            $table->char('ProgramID');
            $table->integer('ProgramDiv');
            $table->char('ProgramName');
            $table->timestamps();
            $table->integer('UpdatePerson')->nullable();// ユーザーID とりあえず
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('M_Authority');
        Schema::dropIfExists('M_AuthorityDetail');
        Schema::dropIfExists('M_Program');
    }
}
