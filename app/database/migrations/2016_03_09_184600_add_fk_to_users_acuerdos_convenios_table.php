<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToUsersAcuerdosConveniosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users_acuerdos_convenios', function(Blueprint $table)
		{
			$table->foreign('idacuerdo_convenio')->references('id')->on('acuerdos_convenios');
			$table->foreign('iduser')->references('id')->on('users');			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users_acuerdos_convenios', function(Blueprint $table)
		{
			$table->dropForeign('users_acuerdos_convenios_idacuerdo_convenio_foreign');			
			$table->dropForeign('users_acuerdos_convenios_iduser_foreign');			
		});
	}

}
