<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConfigTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		//
        Schema::create('config', function(Blueprint $table){
            $table->increments('id');
            $table->string('uid', 150)->unique();
            $table->string('title', 150);
            $table->string('value', 255);
            $table->string('var_type', 30);
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
        Schema::drop('config');
	}

}
