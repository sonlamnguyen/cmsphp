<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		//
		Schema::create('devices', function(Blueprint $table){
            $table->increments('id');
            $table->integer('subnet_id');
            $table->integer('rtu_id');
            $table->integer('device_type');
            $table->string('device_name', 150)->unique();
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
        Schema::drop('devices');
	}

}
