<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToReporteCnTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('reporte_cn', function(Blueprint $table)
		{
			$table->foreign('idot_retiro', 'fk_reporte_CN_ot_retiros1')->references('idot_retiro')->on('ot_retiros')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idprogramacion_reporte_cn', 'fk_reporte_cn_programacion_reporte_cn1')->references('idprogramacion_reporte_cn')->on('programacion_reporte_cn')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('reporte_cn', function(Blueprint $table)
		{
			$table->dropForeign('fk_reporte_CN_ot_retiros1');
			$table->dropForeign('fk_reporte_cn_programacion_reporte_cn1');
		});
	}

}
