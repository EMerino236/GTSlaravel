<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequerimientosClinicosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('requerimientos_clinicos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->integer('id_categoria')->unsigned();
			$table->integer('id_servicio_clinico');
			$table->integer('id_departamento');
			$table->integer('id_responsable');
			$table->date('fecha_ini');
			$table->date('fecha_fin');
			$table->float('presupuesto');
			$table->integer('tipo');
			$table->text('observaciones');
			$table->integer('id_estado')->unsigned();
			$table->integer('id_reporte')->unsigned();
			$table->integer('id_modificador')->nullable();
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
		Schema::drop('requerimientos_clinicos');
	}

}
