<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToReportePaacTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('reporte_paac', function(Blueprint $table)
		{
			$table->foreign('idprogramacion_reporte_paac', 'fk_reporte_paac_programacion_reporte_paac1')->references('idprogramacion_reporte_paac')->on('programacion_reporte_paac')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('reporte_paac', function(Blueprint $table)
		{
			$table->dropForeign('fk_reporte_paac_programacion_reporte_paac1');
		});
	}

}
