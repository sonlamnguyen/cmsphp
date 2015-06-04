<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigSceneTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		//
		Schema::create('scenes', function(Blueprint $table){
            $table->increments('id');
            $table->string('scene_nane', 150)->unique();
            $table->integer('scene_no');
            $table->integer('device_id')->unsigned();
           	$table->foreign('device_id')->references('id')->on('devices'); 
            $table->integer('channel_1_value');
            $table->integer('channel_2_value');
            $table->integer('channel_3_value');
            $table->integer('channel_4_value');
            $table->integer('channel_5_value');
            $table->integer('channel_6_value');
            $table->integer('channel_7_value');
            $table->integer('channel_8_value');
            $table->integer('status');
            $table->timestamps();
        });

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		//
        Schema::drop('scenes');
	}

}
