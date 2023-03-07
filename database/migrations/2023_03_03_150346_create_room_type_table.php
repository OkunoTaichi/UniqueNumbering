<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_building', function (Blueprint $table) {
            $table->char('TenantCode');
            $table->integer('TenantBranch');
            
            $table->char('BuildingCode');
            $table->char('BuildingName');
            $table->char('BuildingAbName');
            $table->boolean('Hidden')->nullable();
            $table->integer('DisplayOrder');
            $table->timestamp('Update')->useCurrent()->nullable();
            $table->char('UpdatePerson')->nullable();// ユーザーID とりあえず
        });

        Schema::create('m_room_type', function (Blueprint $table) {
            $table->char('TenantCode');
            $table->integer('TenantBranch');
            $table->char('RoomTypeCode');
            $table->char('RoomTypeName');
            $table->char('RoomTypeAbName');
            $table->integer('RoomTypeDiv');
            $table->integer('OperationDiv');
            $table->integer('RemainingRoomDiv')->nullable();
            $table->integer('RealTypeCode')->nullable();

            
            $table->boolean('Hidden')->nullable();
            $table->integer('DisplayOrder');
            $table->timestamp('Update')->useCurrent()->nullable();
            $table->char('UpdatePerson')->nullable();// ユーザーID とりあえず
        });

        Schema::create('m_room', function (Blueprint $table) {
            $table->char('TenantCode');
            $table->integer('TenantBranch');
            $table->integer('RoomNo');
            $table->char('BuildingCode');
            $table->char('RoomTypeCode');
            $table->char('RoomName');
            $table->char('RoomAbName');
            $table->integer('CapacityMax');
            $table->integer('CapacityMin');
            $table->integer('Floor');
            $table->boolean('Hidden')->nullable();
            $table->integer('DisplayOrder');
            $table->timestamp('Update')->useCurrent()->nullable();
            $table->char('UpdatePerson')->nullable();// ユーザーID とりあえず
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_building');
        Schema::dropIfExists('m_room_type');
        Schema::dropIfExists('m_room');
    }
}
