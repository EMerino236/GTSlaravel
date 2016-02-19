<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFksToReportePriorizacionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('reporte_priorizacion', function(Blueprint $table)
		{
			$table->foreign('idarea', 'fk_reporte_priorizacion_areas1')->references('idarea')->on('areas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idservicio', 'fk_reporte_priorizacion_servicios1')->references('idservicio')->on('servicios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('iduser', 'fk_reporte_priorizacion_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('reporte_priorizacion', function(Blueprint $table)
		{
			$table->dropForeign('fk_reporte_priorizacion_areas1');
			$table->dropForeign('fk_reporte_priorizacion_servicios1');
			$table->dropForeign('fk_reporte_priorizacion_users1');
		});
	}

}
