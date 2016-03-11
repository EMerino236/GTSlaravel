<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToInstitucionesAcuerdosConveniosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('instituciones_acuerdos_convenios', function(Blueprint $table)
		{
			$table->foreign('idacuerdo_convenio')->references('id')->on('acuerdos_convenios');			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('instituciones_acuerdos_convenios', function(Blueprint $table)
		{
			$table->dropForeign('instituciones_acuerdos_convenios_idacuerdo_convenio_foreign');			
		});
	}

}
