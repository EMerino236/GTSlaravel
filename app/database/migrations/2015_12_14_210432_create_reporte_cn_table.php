<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReporteCnTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reporte_cn', function(Blueprint $table)
		{
			$table->integer('idreporte_CN', true);
			$table->string('numero_reporte_abreviatura', 2);
			$table->string('numero_reporte_correlativo', 4);
			$table->string('numero_reporte_anho', 2);
			$table->string('url', 200)->nullable();
			$table->string('nombre_archivo', 200)->nullable();
			$table->string('nombre_archivo_encriptado', 200)->nullable();
			$table->integer('idot_retiro')->nullable()->index('fk_reporte_CN_ot_retiros1_idx');
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idprogramacion_reporte_cn')->index('fk_reporte_cn_programacion_reporte_cn1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('reporte_cn');
	}

}
