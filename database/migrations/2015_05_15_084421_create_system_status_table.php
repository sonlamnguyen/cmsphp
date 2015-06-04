<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemStatusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		//
		Schema::create('sytem_status', function(Blueprint $table){
            $table->increments('id');
            $table->integer('device_id');
            $table->integer('device_name');
            $table->integer('device_type');
            $table->integer('subnet_id');
            $table->integer('rtu_id');
            $table->integer('channel_id');
            $table->integer('value');
            $table->integer('area_id');
            $table->integer('area_name');
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
        Schema::drop('system_status');
	}

}
