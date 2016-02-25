<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReporteCnPaacToDocumentospaacTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('documentospacc', function(Blueprint $table)
		{
			$table->String('cod_reporte_cn_paac1')->nullable();
			$table->String('cod_reporte_cn_paac2')->nullable();
			$table->String('cod_reporte_cn_paac3')->nullable();
			$table->String('cod_reporte_cn_paac4')->nullable();
			$table->String('cod_reporte_cn_paac5')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('documentospacc', function(Blueprint $table)
		{
			//
		});
	}

}
