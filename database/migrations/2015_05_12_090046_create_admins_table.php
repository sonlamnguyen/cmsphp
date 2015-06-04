<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		//
		Schema::create('admins', function(Blueprint $table){
            $table->increments('id');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->string( 'email' )->unique();
            $table->string( 'password' , 64 );
            $table->string( 'name' );
			$table->string('role', 30);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
        Schema::drop('admins');
	}

}
