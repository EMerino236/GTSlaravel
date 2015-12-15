<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOtBusquedaInfosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ot_busqueda_infos', function(Blueprint $table)
		{
			$table->integer('idot_busqueda_info', true);
			$table->string('ot_tipo_abreviatura', 3)->nullable();
			$table->string('ot_correlativo', 4)->nullable();
			$table->integer('idarea')->index('fk_ot_busqueda_infos_areas1_idx');
			$table->integer('id_usuariosolicitante')->index('fk_ot_busqueda_infos_users1_idx');
			$table->integer('id_usuarioelaborador')->index('fk_ot_busqueda_infos_users2_idx');
			$table->integer('id_usuarioencargado')->index('fk_ot_busqueda_infos_users3_idx');
			$table->dateTime('fecha_conformidad')->nullable();
			$table->dateTime('fecha_programacion')->nullable();
			$table->float('costo_total_personal', 10, 0)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idestado_ot')->index('fk_ot_busqueda_infos_estados1_idx');
			$table->integer('idsolicitud_busqueda_info')->index('fk_ot_busqueda_infos_solicitud_busqueda_infos1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ot_busqueda_infos');
	}

}
