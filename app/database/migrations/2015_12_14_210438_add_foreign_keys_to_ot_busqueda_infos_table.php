<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOtBusquedaInfosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ot_busqueda_infos', function(Blueprint $table)
		{
			$table->foreign('id_usuariosolicitante', 'fk_ot_busqueda_infos_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_usuarioelaborador', 'fk_ot_busqueda_infos_users2')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idarea', 'fk_ot_busqueda_infos_areas1')->references('idarea')->on('areas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idestado_ot', 'fk_ot_busqueda_infos_estados1')->references('idestado')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idsolicitud_busqueda_info', 'fk_ot_busqueda_infos_solicitud_busqueda_infos1')->references('idsolicitud_busqueda_info')->on('solicitud_busqueda_infos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_usuarioencargado', 'fk_ot_busqueda_infos_users3')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ot_busqueda_infos', function(Blueprint $table)
		{
			$table->dropForeign('fk_ot_busqueda_infos_users1');
			$table->dropForeign('fk_ot_busqueda_infos_users2');
			$table->dropForeign('fk_ot_busqueda_infos_areas1');
			$table->dropForeign('fk_ot_busqueda_infos_estados1');
			$table->dropForeign('fk_ot_busqueda_infos_solicitud_busqueda_infos1');
			$table->dropForeign('fk_ot_busqueda_infos_users3');
		});
	}

}
