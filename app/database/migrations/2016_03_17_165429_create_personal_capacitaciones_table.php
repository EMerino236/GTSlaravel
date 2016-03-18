<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalCapacitacionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('personal_capacitaciones', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre',100);
			$table->string('apellidos',200);
			$table->integer('id_servicio');
			$table->integer('id_tipodocumento');
			$table->integer('numero_documento');
			$table->integer('id_capacitacion')->unsigned();
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
		Schema::drop('personal_capacitaciones');
	}

}
