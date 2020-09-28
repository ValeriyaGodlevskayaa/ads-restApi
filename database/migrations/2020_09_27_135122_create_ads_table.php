<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->text('description');
            $table->float('price');
            $table->timestamps();

        });

        Schema::create('ad_photos', function (Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('link');
            $table->boolean('main');
            $table->unsignedInteger('ad_id');
            $table->foreign('ad_id')->references('id')->on('ads')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ad_photos');
        Schema::dropIfExists('ads');
    }
}
