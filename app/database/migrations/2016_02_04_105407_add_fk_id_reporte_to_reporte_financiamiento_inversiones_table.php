<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkIdReporteToReporteFinanciamientoInversionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('reporte_financiamiento_inversiones', function(Blueprint $table)
		{
			$table->foreign('id_reporte')->references('id')->on('reporte_financiamiento');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('reporte_financiamiento_inversiones', function(Blueprint $table)
		{
			$table->dropForeign('reporte_financiamiento_inversiones_id_reporte_foreign');
		});
	}

}
