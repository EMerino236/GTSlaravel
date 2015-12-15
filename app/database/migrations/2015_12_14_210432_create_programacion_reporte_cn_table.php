<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProgramacionReporteCnTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('programacion_reporte_cn', function(Blueprint $table)
		{
			$table->integer('idprogramacion_reporte_cn', true);
			$table->integer('idarea')->index('fk_programacion_reporte_cn_areas1_idx');
			$table->integer('idservicio')->index('fk_programacion_reporte_cn_servicios1_idx');
			$table->integer('iduser')->index('fk_programacion_reporte_cn_users1_idx');
			$table->integer('idtipo_reporte_CN')->index('fk_programacion_reporte_cn_tipo_reporte_cn1_idx');
			$table->date('fecha')->nullable();
			$table->string('nombre_reporte', 100)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idestado_programacion_reportes')->index('fk_programacion_reporte_cn_estado_programacion_reportes1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('programacion_reporte_cn');
	}

}
