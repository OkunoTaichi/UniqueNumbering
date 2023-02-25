<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_person', function (Blueprint $table) {
            $table->char('TenantCode');
            $table->integer('TenantBranch');
            $table->char('PersonCode');
            $table->char('PersonName');
            $table->integer('AuthorityCode');
            $table->char('Password');
            $table->boolean('Hidden')->nullable();
            $table->integer('DisplayOrder');
            $table->timestamp('updated_at')->useCurrent()->nullable();
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
        Schema::dropIfExists('m_person');
    }
}
