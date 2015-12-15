<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOtInspecEquiposxactivosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ot_inspec_equiposxactivos', function(Blueprint $table)
		{
			$table->integer('idot_inspec_equiposxactivo', true);
			$table->integer('idot_inspec_equipo')->index('fk_ot_inspec_equipos_has_activos_ot_inspec_equipos1_idx');
			$table->integer('idactivo')->index('fk_ot_inspec_equipos_has_activos_activos1_idx');
			$table->string('observaciones', 200)->nullable();
			$table->string('imagen_url', 200)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->string('nombre_archivo', 200)->nullable();
			$table->string('nombre_archivo_encriptado', 200)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ot_inspec_equiposxactivos');
	}

}
