<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReporteIncumplimientosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reporte_incumplimientos', function(Blueprint $table)
		{
			$table->integer('idreporte_incumplimiento', true);
			$table->string('numero_reporte_abreviatura', 2);
			$table->string('numero_reporte_correlativo', 4);
			$table->string('numero_reporte_anho', 2);
			$table->integer('tipo_reporte');
			$table->dateTime('fecha')->nullable();
			$table->string('descripcion_corta', 100)->nullable();
			$table->string('descripcion_servicio', 200)->nullable();
			$table->float('costo_generado', 10, 0);
			$table->string('accion_correctiva', 200)->nullable();
			$table->integer('flag_reincidente');
			$table->string('acciones', 200)->nullable();
			$table->string('resultados', 200)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idservicio')->index('fk_reporte_incumplimientos_servicios1_idx');
			$table->integer('idproveedor')->index('fk_reporte_incumplimientos_proveedores1_idx');
			$table->integer('id_responsable')->index('fk_reporte_incumplimientos_users1_idx');
			$table->integer('id_elaborado')->index('fk_reporte_incumplimientos_users2_idx');
			$table->integer('id_autorizado')->index('fk_reporte_incumplimientos_users3_idx');
			$table->integer('idestado')->index('fk_reporte_incumplimientos_estados1_idx');
			$table->string('codigo_ot', 10)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('reporte_incumplimientos');
	}

}
