<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReporteInstalacionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reporte_instalaciones', function(Blueprint $table)
		{
			$table->integer('idreporte_instalacion', true);
			$table->string('numero_reporte_abreviatura', 2);
			$table->string('numero_reporte_correlativo', 4);
			$table->string('numero_reporte_anho', 2);
			$table->string('descripcion', 200)->nullable();
			$table->dateTime('fecha')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idtipo_reporte_instalacion')->index('fk_reporte_instalaciones_tipo_reporte_instalaciones1_idx');
			$table->integer('idestado')->index('fk_reporte_instalaciones_estados1_idx');
			$table->integer('id_responsable')->index('fk_reporte_instalaciones_users1_idx');
			$table->string('codigo_compra', 45)->nullable();
			$table->integer('idproveedor')->index('fk_reporte_instalaciones_proveedores1_idx');
			$table->integer('idarea')->index('fk_reporte_instalaciones_areas1_idx');
			$table->integer('idreporte_instalacion_entorno_concluido')->nullable()->index('fk_reporte_instalaciones_reporte_instalaciones1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('reporte_instalaciones');
	}

}
