<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterIdservicioToProgramacionReporteCnTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('programacion_reporte_cn', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE programacion_reporte_cn MODIFY idservicio INTEGER NULL;');
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
			//
		});
	}

}
