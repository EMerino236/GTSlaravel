<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEspecificacionTecnicaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('especificacion_tecnica', function(Blueprint $table)
		{					
			$table->integer('idespecificacion_tecnica', true);
			$table->integer('idtipo_especificacion_tecnica')->index('fk_expediente_tecnico_tipo_especificacion_tecnica1_idx');
			$table->string('nombre_equipo',200);
			$table->string('nombre',500);
			$table->integer('correlativo_por_tipo_especificacion');
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
		Schema::drop('especificacion_tecnica');
	}

}
