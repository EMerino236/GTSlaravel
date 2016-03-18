<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCamposToCapacitacionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('capacitaciones', function(Blueprint $table)
		{
			$table->integer('numero_sesiones');
			$table->integer('horasxsesiones');
			$table->string('objetivo',500);
			$table->string('personal_involucrado',500);
			$table->string('competencia',500);
			$table->string('url', 200)->nullable();
			$table->string('nombre_archivo', 200)->nullable();
			$table->string('nombre_archivo_encriptado', 200)->nullable();
			$table->dropColumn('codigo_patrimonial');
			$table->dropColumn('equipo_relacionado');
			$table->dropColumn('id_departamento');
			$table->integer('id_activo');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('capacitaciones', function(Blueprint $table)
		{
			//
		});
	}

}
