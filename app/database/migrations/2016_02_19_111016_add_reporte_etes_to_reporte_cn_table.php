<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReporteEtesToReporteCnTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('reporte_cn', function(Blueprint $table)
		{
			$table->integer('idreporte_etes1')->nullable();
			$table->integer('idreporte_etes2')->nullable();
			$table->integer('idreporte_etes3')->nullable();
			$table->integer('idreporte_etes4')->nullable();
			$table->integer('idreporte_etes5')->nullable();
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
			//
		});
	}

}
