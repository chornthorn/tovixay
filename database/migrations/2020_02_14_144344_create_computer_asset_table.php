<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComputerAssetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('computer_asset', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('asset_id')->unsigned();
            $table->foreign('asset_id')->references('id')
                ->on('assets')
                ->onDelete('restrict');
            $table->bigInteger('computer_id')->unsigned();
            $table->foreign('computer_id')->references('id')
                ->on('computers')
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
        Schema::dropIfExists('computer_asset');
    }
}
