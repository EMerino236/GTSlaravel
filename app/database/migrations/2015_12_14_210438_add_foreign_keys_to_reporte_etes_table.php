<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToReporteEtesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('reporte_etes', function(Blueprint $table)
		{
			$table->foreign('idprogramacion_reporte_etes', 'fk_reporte_etes_programacion_reporte_etes1')->references('idprogramacion_reporte_etes')->on('programacion_reporte_etes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('reporte_etes', function(Blueprint $table)
		{
			$table->dropForeign('fk_reporte_etes_programacion_reporte_etes1');
		});
	}

}
