<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToProgramacionReporteCnTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('programacion_reporte_cn', function(Blueprint $table)
		{
			$table->foreign('idarea', 'fk_programacion_reporte_cn_areas1')->references('idarea')->on('areas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idservicio', 'fk_programacion_reporte_cn_servicios1')->references('idservicio')->on('servicios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('iduser', 'fk_programacion_reporte_cn_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idtipo_reporte_CN', 'fk_programacion_reporte_cn_tipo_reporte_cn1')->references('idtipo_reporte_CN')->on('tipo_reporte_cn')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idestado_programacion_reportes', 'fk_programacion_reporte_cn_estado_programacion_reportes1')->references('idestado_programacion_reportes')->on('estado_programacion_reportes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('programacion_reporte_cn', function(Blueprint $table)
		{
			$table->dropForeign('fk_programacion_reporte_cn_areas1');
			$table->dropForeign('fk_programacion_reporte_cn_servicios1');
			$table->dropForeign('fk_programacion_reporte_cn_users1');
			$table->dropForeign('fk_programacion_reporte_cn_tipo_reporte_cn1');
			$table->dropForeign('fk_programacion_reporte_cn_estado_programacion_reportes1');
		});
	}

}
