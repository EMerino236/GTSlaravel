<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSoporteTecnicosxactivosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('soporte_tecnicosxactivos', function(Blueprint $table)
		{
			$table->integer('idsoporte_tecnicosxactivo', true);
			$table->integer('idsoporte_tecnico')->index('fk_soporte_tecnicos_has_activos_soporte_tecnicos1_idx');
			$table->integer('idactivo')->index('fk_soporte_tecnicos_has_activos_activos1_idx');
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idestado')->index('fk_soporte_tecnicosxactivos_estados1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('soporte_tecnicosxactivos');
	}

}
