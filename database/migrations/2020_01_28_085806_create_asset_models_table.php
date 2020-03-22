<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('model_code',50)->nullable();
            $table->string('model_name',100)->nullable();
            $table->integer('model_status')->default('1');
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
        Schema::dropIfExists('asset_models');
    }
}
