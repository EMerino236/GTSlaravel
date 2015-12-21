<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterIdservicioToProgramacionReportePaacTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('programacion_reporte_paac', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE programacion_reporte_paac MODIFY idservicio INTEGER NULL;');
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
			//
		});
	}

}
