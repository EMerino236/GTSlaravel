<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReportePaacTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reporte_paac', function(Blueprint $table)
		{
			$table->integer('idreporte_PAAC', true);
			$table->string('numero_reporte_abreviatura', 2);
			$table->string('numero_reporte_correlativo', 4);
			$table->string('numero_reporte_anho', 2);
			$table->string('url', 200)->nullable();
			$table->string('nombre_archivo', 200)->nullable();
			$table->string('nombre_archivo_encriptado', 200)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idprogramacion_reporte_paac')->index('fk_reporte_paac_programacion_reporte_paac1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('reporte_paac');
	}

}
