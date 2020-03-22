<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComputersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('computers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('asset_id')->unsigned();
            $table->foreign('asset_id')->references('id')
                ->on('assets')
                ->onDelete('restrict');
            $table->string('monitor_item',50)->nullable();
            $table->string('mainboard_item',50)->nullable();
            $table->string('cpu_item',50)->nullable();
            $table->string('harddisk_item',50)->nullable();
            $table->string('ram_item',50)->nullable();
            $table->string('powersupply_item',50)->nullable();
            $table->string('keyboard_item',50)->nullable();
            $table->string('mouse_item',50)->nullable();
            $table->string('cdrom_item',50)->nullable();
            $table->integer('computer_status')->default('1');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')
                ->on('users')
                ->onDelete('restrict');
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
        Schema::dropIfExists('computers');
    }
}
