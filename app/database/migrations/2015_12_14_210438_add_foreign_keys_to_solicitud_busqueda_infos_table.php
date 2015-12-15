<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSolicitudBusquedaInfosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('solicitud_busqueda_infos', function(Blueprint $table)
		{
			$table->foreign('idarea', 'fk_solicitud_busqueda_infos_areas1')->references('idarea')->on('areas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idtipo_busqueda_info', 'fk_solicitud_busqueda_infos_tipo_busqueda_infos1')->references('idtipo_busqueda_info')->on('tipo_busqueda_infos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_usuarioencargado', 'fk_solicitud_busqueda_infos_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('solicitud_busqueda_infos', function(Blueprint $table)
		{
			$table->dropForeign('fk_solicitud_busqueda_infos_areas1');
			$table->dropForeign('fk_solicitud_busqueda_infos_tipo_busqueda_infos1');
			$table->dropForeign('fk_solicitud_busqueda_infos_users1');
		});
	}

}
