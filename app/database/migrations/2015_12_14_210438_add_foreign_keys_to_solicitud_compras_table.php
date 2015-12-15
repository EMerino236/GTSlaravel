<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSolicitudComprasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('solicitud_compras', function(Blueprint $table)
		{
			$table->foreign('idtipo_solicitud_compra', 'fk_solicitud_compras_tipo_solicitud_compras1')->references('idtipo_solicitud_compra')->on('tipo_solicitud_compras')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idfamilia_activo', 'fk_solicitud_compras_familia_activos1')->references('idfamilia_activo')->on('familia_activos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idservicio', 'fk_solicitud_compras_servicios1')->references('idservicio')->on('servicios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_responsable', 'fk_solicitud_compras_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idestado', 'fk_solicitud_compras_estados1')->references('idestado')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('solicitud_compras', function(Blueprint $table)
		{
			$table->dropForeign('fk_solicitud_compras_tipo_solicitud_compras1');
			$table->dropForeign('fk_solicitud_compras_familia_activos1');
			$table->dropForeign('fk_solicitud_compras_servicios1');
			$table->dropForeign('fk_solicitud_compras_users1');
			$table->dropForeign('fk_solicitud_compras_estados1');
		});
	}

}
