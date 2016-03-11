<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersAcuerdosConveniosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_acuerdos_convenios', function(Blueprint $table)
		{
			$table->increments('id');			
			$table->integer('idacuerdo_convenio')->unsigned();
			$table->integer('iduser');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users_acuerdos_convenios');
	}

}
