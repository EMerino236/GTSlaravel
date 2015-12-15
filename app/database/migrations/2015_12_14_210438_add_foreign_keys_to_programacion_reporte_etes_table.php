<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToProgramacionReporteEtesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('programacion_reporte_etes', function(Blueprint $table)
		{
			$table->foreign('iduser', 'fk_programacion_reporte_etes_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idtipo_reporte_ETES', 'fk_programacion_reporte_etes_tipo_reporte_etes1')->references('idtipo_reporte_ETES')->on('tipo_reporte_etes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idestado_programacion_reportes', 'fk_programacion_reporte_etes_estado_programacion_reportes1')->references('idestado_programacion_reportes')->on('estado_programacion_reportes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('programacion_reporte_etes', function(Blueprint $table)
		{
			$table->dropForeign('fk_programacion_reporte_etes_users1');
			$table->dropForeign('fk_programacion_reporte_etes_tipo_reporte_etes1');
			$table->dropForeign('fk_programacion_reporte_etes_estado_programacion_reportes1');
		});
	}

}
