<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDetalleReporteInstalacionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('detalle_reporte_instalaciones', function(Blueprint $table)
		{
			$table->foreign('idreporte_instalacion', 'fk_detalle_reporte_instalaciones_reporte_instalaciones1')->references('idreporte_instalacion')->on('reporte_instalaciones')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('detalle_reporte_instalaciones', function(Blueprint $table)
		{
			$table->dropForeign('fk_detalle_reporte_instalaciones_reporte_instalaciones1');
		});
	}

}
