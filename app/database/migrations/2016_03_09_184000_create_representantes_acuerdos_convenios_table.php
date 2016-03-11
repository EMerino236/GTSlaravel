<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepresentantesAcuerdosConveniosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('representantes_acuerdos_convenios', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre',200);
			$table->string('ap_paterno',200);
			$table->string('ap_materno',200);
			$table->string('area',200);
			$table->string('rol',200);			
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
		Schema::drop('representantes_acuerdos_convenios');
	}

}
