<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReporteRetirosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reporte_retiros', function(Blueprint $table)
		{
			$table->integer('idreporte_retiro', true);
			$table->string('reporte_tipo_abreviatura', 2)->nullable();
			$table->string('reporte_correlativo', 4)->nullable();
			$table->string('reporte_activo_abreviatura', 2)->nullable();
			$table->integer('idactivo')->index('fk_reporte_retiros_activos1_idx');
			$table->string('descripcion', 200)->nullable();
			$table->integer('idmotivo_retiro')->index('fk_reporte_retiros_motivo_retiros1_idx');
			$table->dateTime('fecha_baja')->nullable();
			$table->float('costo', 10, 0)->nullable();
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
		Schema::drop('reporte_retiros');
	}

}
