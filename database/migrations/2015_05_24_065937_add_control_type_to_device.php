<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddControlTypeToDevice extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		//
		Schema::table('devices', function($table){
			$table->integer('control_type');
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
			$table->dropColumn('control_type');
		});	
	}

}
