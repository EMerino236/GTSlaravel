<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActividadCapacitacionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('actividad_capacitaciones', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre',100);
			$table->string('descripcion',200);
			$table->integer('id_servicio');
			$table->date('fecha');
			$table->integer('duracion');
			$table->integer('id_sesion')->unsigned();
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
		Schema::drop('actividad_capacitaciones');
	}

}
