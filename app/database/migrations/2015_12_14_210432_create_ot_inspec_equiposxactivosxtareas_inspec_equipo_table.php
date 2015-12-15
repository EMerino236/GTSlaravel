<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOtInspecEquiposxactivosxtareasInspecEquipoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ot_inspec_equiposxactivosxtareas_inspec_equipo', function(Blueprint $table)
		{
			$table->integer('idot_inspec_equiposxactivosxtareas_inspec_equipo', true);
			$table->integer('idot_inspec_equiposxactivo')->index('fk_ot_inspec_equiposxactivos_has_tareas_inspec_equipos_ot_i_idx');
			$table->integer('idtareas_inspec_equipo')->index('fk_ot_inspec_equiposxactivos_has_tareas_inspec_equipos_tare_idx');
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idestado_realizado')->index('fk_ot_inspec_equiposxactivosxtareas_inspec_equipo_estados1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ot_inspec_equiposxactivosxtareas_inspec_equipo');
	}

}
