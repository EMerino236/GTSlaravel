<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToReporteInvestigacionxtipoCapacitacionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('reporte_investigacionxtipo_capacitacion', function(Blueprint $table)
		{
			$table->foreign('idreporte')->references('id')->on('reporte_investigacion');
			$table->foreign('idtipo')->references('id')->on('tipo_capacitacion_riesgos');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('reporte_investigacionxtipo_capacitacion', function(Blueprint $table)
		{
			$table->dropForeign('reporte_investigacionxtipo_capacitacion_idreporte_foreign');
			$table->dropForeign('reporte_investigacionxtipo_capacitacion_idtipo_foreign');
		});
	}

}
