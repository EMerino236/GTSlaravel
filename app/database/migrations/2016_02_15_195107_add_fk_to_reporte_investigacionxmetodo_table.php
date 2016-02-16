<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToReporteInvestigacionxmetodoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('reporte_investigacionxmetodo', function(Blueprint $table)
		{
			$table->foreign('idreporte')->references('id')->on('reporte_investigacion');
			$table->foreign('idmetodo')->references('id')->on('metodo_difusion');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('reporte_investigacionxmetodo', function(Blueprint $table)
		{
			$table->dropForeign('reporte_investigacionxmetodo_idreporte_foreign');
			$table->dropForeign('reporte_investigacionxmetodo_idmetodo_foreign');
		});
	}

}
