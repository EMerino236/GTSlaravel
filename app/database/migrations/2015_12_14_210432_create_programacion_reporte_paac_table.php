<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProgramacionReportePaacTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('programacion_reporte_paac', function(Blueprint $table)
		{
			$table->integer('idprogramacion_reporte_paac', true);
			$table->string('nombre_reporte', 100)->nullable();
			$table->date('fecha')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idtipo_reporte_PAAC')->index('fk_programacion_reporte_paac_tipo_reporte_paac1_idx');
			$table->integer('iduser')->index('fk_programacion_reporte_paac_users1_idx');
			$table->integer('idservicio')->index('fk_programacion_reporte_paac_servicios1_idx');
			$table->integer('idarea')->index('fk_programacion_reporte_paac_areas1_idx');
			$table->integer('idestado_programacion_reportes')->index('fk_programacion_reporte_paac_estado_programacion_reportes1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('programacion_reporte_paac');
	}

}
