<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReporteEtesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reporte_etes', function(Blueprint $table)
		{
			$table->integer('idreporte_ETES', true);
			$table->string('numero_reporte_abreviatura', 2);
			$table->string('numero_reporte_correlativo', 4);
			$table->string('numero_reporte_anho', 2);
			$table->string('url', 200)->nullable();
			$table->string('nombre_archivo', 200)->nullable();
			$table->string('nombre_archivo_encriptado', 200)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idprogramacion_reporte_etes')->index('fk_reporte_etes_programacion_reporte_etes1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('reporte_etes');
	}

}
