<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetalleReporteInstalacionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('detalle_reporte_instalaciones', function(Blueprint $table)
		{
			$table->integer('iddetalle_reporte_instalacion', true);
			$table->string('nombre_tarea', 100);
			$table->integer('tarea_realizada')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idreporte_instalacion')->index('fk_detalle_reporte_instalaciones_reporte_instalaciones1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('detalle_reporte_instalaciones');
	}

}
