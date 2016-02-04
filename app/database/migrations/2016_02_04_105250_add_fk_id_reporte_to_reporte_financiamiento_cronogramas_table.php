<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkIdReporteToReporteFinanciamientoCronogramasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('reporte_financiamiento_cronogramas', function(Blueprint $table)
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
		Schema::table('reporte_financiamiento_cronogramas', function(Blueprint $table)
		{
			$table->dropForeign('reporte_financiamiento_cronogramas_id_reporte_foreign');
		});
	}

}
