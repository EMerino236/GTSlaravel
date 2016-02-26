<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFechasToReporteCalibracionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('reporte_calibracion', function(Blueprint $table)
		{
			$table->date('fecha_calibracion')->nullable();
			$table->date('fecha_proxima_calibracion')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('reporte_calibracion', function(Blueprint $table)
		{
			//
		});
	}

}
