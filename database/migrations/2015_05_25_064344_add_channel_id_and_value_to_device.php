<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChannelIdAndValueToDevice extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		//
		Schema::table('devices', function($table){
			$table->integer('channel_id');
			$table->integer('value')->default(0);
		});	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		//
		Schema::table('devices', function($table){
			$table->dropColumn('channel_id');
			$table->dropColumn('value');
		});
	}

}
