<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSolicitudBusquedaInfosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('solicitud_busqueda_infos', function(Blueprint $table)
		{
			$table->integer('idsolicitud_busqueda_info', true);
			$table->string('sot_tipo_abreviatura', 3)->nullable();
			$table->string('sot_correlativo', 4)->nullable();
			$table->dateTime('fecha_solicitud')->nullable();
			$table->string('descripcion', 200);
			$table->string('motivo', 200);
			$table->string('detalle', 200);
			$table->timestamps();
			$table->softDeletes();
			$table->integer('id');
			$table->integer('id_usuarioencargado')->index('fk_solicitud_busqueda_infos_users1_idx');
			$table->integer('idestado');
			$table->integer('idarea')->index('fk_solicitud_busqueda_infos_areas1_idx');
			$table->integer('idtipo_busqueda_info')->index('fk_solicitud_busqueda_infos_tipo_busqueda_infos1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('solicitud_busqueda_infos');
	}

}
