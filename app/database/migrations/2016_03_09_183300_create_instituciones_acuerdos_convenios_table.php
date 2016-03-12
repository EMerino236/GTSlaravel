<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstitucionesAcuerdosConveniosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('instituciones_acuerdos_convenios', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre',200);			
			$table->integer('idacuerdo_convenio')->unsigned();
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
		Schema::drop('instituciones_acuerdos_convenios');
	}

}
