<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToProgramacionReportePaacTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('programacion_reporte_paac', function(Blueprint $table)
		{
			$table->foreign('idtipo_reporte_PAAC', 'fk_programacion_reporte_paac_tipo_reporte_paac1')->references('idtipo_reporte_PAAC')->on('tipo_reporte_paac')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('iduser', 'fk_programacion_reporte_paac_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idservicio', 'fk_programacion_reporte_paac_servicios1')->references('idservicio')->on('servicios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idarea', 'fk_programacion_reporte_paac_areas1')->references('idarea')->on('areas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idestado_programacion_reportes', 'fk_programacion_reporte_paac_estado_programacion_reportes1')->references('idestado_programacion_reportes')->on('estado_programacion_reportes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('programacion_reporte_paac', function(Blueprint $table)
		{
			$table->dropForeign('fk_programacion_reporte_paac_tipo_reporte_paac1');
			$table->dropForeign('fk_programacion_reporte_paac_users1');
			$table->dropForeign('fk_programacion_reporte_paac_servicios1');
			$table->dropForeign('fk_programacion_reporte_paac_areas1');
			$table->dropForeign('fk_programacion_reporte_paac_estado_programacion_reportes1');
		});
	}

}
