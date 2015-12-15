<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSolicitudOrdenTrabajosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('solicitud_orden_trabajos', function(Blueprint $table)
		{
			$table->foreign('id', 'fk_solicitud_orden_trabajos_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idestado', 'fk_solicitud_orden_trabajos_estados1')->references('idestado')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idactivo', 'fk_solicitud_orden_trabajos_activos1')->references('idactivo')->on('activos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('solicitud_orden_trabajos', function(Blueprint $table)
		{
			$table->dropForeign('fk_solicitud_orden_trabajos_users1');
			$table->dropForeign('fk_solicitud_orden_trabajos_estados1');
			$table->dropForeign('fk_solicitud_orden_trabajos_activos1');
		});
	}

}
