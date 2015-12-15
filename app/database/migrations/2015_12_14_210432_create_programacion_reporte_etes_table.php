<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProgramacionReporteEtesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('programacion_reporte_etes', function(Blueprint $table)
		{
			$table->integer('idprogramacion_reporte_etes', true);
			$table->string('nombre_reporte', 100)->nullable();
			$table->date('fecha')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('iduser')->index('fk_programacion_reporte_etes_users1_idx');
			$table->integer('idtipo_reporte_ETES')->index('fk_programacion_reporte_etes_tipo_reporte_etes1_idx');
			$table->integer('idestado_programacion_reportes')->index('fk_programacion_reporte_etes_estado_programacion_reportes1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('programacion_reporte_etes');
	}

}
