<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramacionCompraAdquisicionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('programacion_compra_adquisicion', function(Blueprint $table)
		{
			$table->integer('idprogramacion_compra', true);
			$table->string('codigo_compra', 100);
			$table->string('descripcion_corta', 100);
			$table->integer('idtipo_compra')->index('fk_programacion_compra_adquisicion_tipo_compra1_idx');
			$table->integer('cantidad');
			$table->integer('idunidad_medida')->index('fk_programacion_compra_adquisicion_unidad_medida1_idx');
			$table->float('costo_aproximado', 10, 2);
			$table->integer('idarea')->index('fk_programacion_compra_adquisicion_areas1_idx');
			$table->integer('idservicio')->index('fk_programacion_compra_adquisicion_servicios1_idx');
			$table->integer('iduser')->index('fk_programacion_compra_adquisicion_users1_idx');
			$table->integer('idresponsable')->index('fk_programacion_compra_adquisicion_users2_idx');
			$table->string('descripcion', 200);
			$table->date('fecha_inicio_evaluacion');
			$table->date('fecha_aproximada_adquisicion');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('programacion_compra_adquisicion');
	}

}
