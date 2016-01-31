<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReporteFinanciamientoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reporte_financiamiento', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->integer('id_categoria')->unsigned();
			$table->integer('id_servicio_clinico');
			$table->integer('id_departamento');
			$table->integer('id_responsable');
			$table->text('descripcion');
			$table->text('objetivos');
			$table->text('impacto');
			$table->text('costo_beneficio');
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
		Schema::drop('reporte_financiamiento');
	}

}
