<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToEspecificacionTecnicaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('especificacion_tecnica', function(Blueprint $table)
		{
			$table->foreign('idtipo_especificacion_tecnica','fk_expediente_tecnico_tipo_especificacion_tecnica1_idx')->references('idtipo_especificacion_tecnica')->on('tipo_especificacion_tecnica');			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('especificacion_tecnica', function(Blueprint $table)
		{
			$table->dropforeign('fk_expediente_tecnico_tipo_especificacion_tecnica1_idx');			
		});
	}

}
