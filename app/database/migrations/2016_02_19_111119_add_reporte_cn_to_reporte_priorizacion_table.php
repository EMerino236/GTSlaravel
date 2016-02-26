<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReporteCnToReportePriorizacionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('reporte_priorizacion', function(Blueprint $table)
		{
			$table->integer('idreporte_cn1')->nullable();
			$table->integer('idreporte_cn2')->nullable();
			$table->integer('idreporte_cn3')->nullable();
			$table->integer('idreporte_cn4')->nullable();
			$table->integer('idreporte_cn5')->nullable();
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
			//
		});
	}

}
