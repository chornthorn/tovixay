<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('asset_code',15)->nullable();
            $table->string('asset_it_code',15)->nullable();
            $table->string('asset_name',255)->nullable();
            $table->string('asset_serial',15)->nullable();
            $table->string('asset_qty',10)->nullable();
            $table->string('asset_unit',10)->nullable();
            $table->integer('delete_status')->default('1');
            $table->string('asset_image',255)->default('default.png');
            $table->string('asset_remark',255)->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')
                ->on('users')
                ->onDelete('restrict');
            $table->bigInteger('brand_id')->unsigned();
            $table->foreign('brand_id')->references('id')
                ->on('brands')
                ->onDelete('restrict');
            $table->bigInteger('model_id')->unsigned();
            $table->foreign('model_id')->references('id')
                ->on('asset_models')
                ->onDelete('restrict');
            $table->string('category_id',10);
            $table->foreign('category_id')->references('id')
                ->on('categories')
                ->onDelete('restrict');
            $table->bigInteger('status_id')->unsigned();
            $table->foreign('status_id')->references('id')
                ->on('statuses')
                ->onDelete('restrict');
            $table->bigInteger('costcenter_id')->unsigned();
            $table->foreign('costcenter_id')->references('id')
                ->on('cost_centers')
                ->onDelete('restrict');
            $table->bigInteger('location_id')->unsigned();
            $table->foreign('location_id')->references('id')
                ->on('locations')
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
        Schema::dropIfExists('assets');
    }
}
