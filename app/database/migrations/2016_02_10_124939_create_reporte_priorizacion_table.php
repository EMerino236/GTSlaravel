<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportePriorizacionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reporte_priorizacion', function(Blueprint $table)
		{
			$table->integer('idreporte_priorizacion', true);
			$table->string('numero_reporte_abreviatura', 2);
			$table->string('numero_reporte_correlativo', 4);
			$table->string('numero_reporte_anho', 2);
			$table->integer('idarea')->index('fk_reporte_priorizacion_areas1_idx');
			$table->integer('idservicio')->nullable()->index('fk_reporte_priorizacion_servicios1_idx');
			$table->integer('iduser')->index('fk_reporte_priorizacion_users1_idx');
			$table->string('url', 200)->nullable();
			$table->string('nombre_archivo', 200)->nullable();
			$table->string('nombre_archivo_encriptado', 200)->nullable();
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
		Schema::drop('reporte_priorizacion');
	}

}
