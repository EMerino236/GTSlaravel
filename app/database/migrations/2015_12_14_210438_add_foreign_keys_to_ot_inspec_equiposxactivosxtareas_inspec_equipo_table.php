<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOtInspecEquiposxactivosxtareasInspecEquipoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ot_inspec_equiposxactivosxtareas_inspec_equipo', function(Blueprint $table)
		{
			$table->foreign('idot_inspec_equiposxactivo', 'fk_ot_inspec_equiposxactivos_has_tareas_inspec_equipos_ot_ins1')->references('idot_inspec_equiposxactivo')->on('ot_inspec_equiposxactivos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idtareas_inspec_equipo', 'fk_ot_inspec_equiposxactivos_has_tareas_inspec_equipos_tareas1')->references('idtareas_inspec_equipo')->on('tareas_inspec_equipos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idestado_realizado', 'fk_ot_inspec_equiposxactivosxtareas_inspec_equipo_estados1')->references('idestado')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ot_inspec_equiposxactivosxtareas_inspec_equipo', function(Blueprint $table)
		{
			$table->dropForeign('fk_ot_inspec_equiposxactivos_has_tareas_inspec_equipos_ot_ins1');
			$table->dropForeign('fk_ot_inspec_equiposxactivos_has_tareas_inspec_equipos_tareas1');
			$table->dropForeign('fk_ot_inspec_equiposxactivosxtareas_inspec_equipo_estados1');
		});
	}

}
