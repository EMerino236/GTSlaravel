<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSolicitudOrdenTrabajosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('solicitud_orden_trabajos', function(Blueprint $table)
		{
			$table->integer('idsolicitud_orden_trabajo', true);
			$table->string('sot_tipo_abreviatura', 3)->nullable();
			$table->string('sot_correlativo', 4)->nullable();
			$table->string('sot_activo_abreviatura', 2)->nullable();
			$table->dateTime('fecha_solicitud')->nullable();
			$table->string('especificacion_servicio', 100);
			$table->string('motivo', 200);
			$table->string('justificacion', 200);
			$table->timestamps();
			$table->softDeletes();
			$table->integer('id')->index('fk_solicitud_orden_trabajos_users1_idx');
			$table->integer('idestado')->index('fk_solicitud_orden_trabajos_estados1_idx');
			$table->integer('idactivo')->index('fk_solicitud_orden_trabajos_activos1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('solicitud_orden_trabajos');
	}

}
