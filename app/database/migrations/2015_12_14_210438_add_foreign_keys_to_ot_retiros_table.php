<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOtRetirosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ot_retiros', function(Blueprint $table)
		{
			$table->foreign('id_usuariosolicitante', 'fk_orden_trabajo_retiro_servicios_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_usuarioelaborador', 'fk_orden_trabajo_retiro_servicios_users2')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idubicacion_fisica', 'fk_ot_retiros_ubicacion_fisicas1')->references('idubicacion_fisica')->on('ubicacion_fisicas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idservicio', 'fk_ot_retiros_servicios1')->references('idservicio')->on('servicios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idactivo', 'fk_ot_retiros_activos1')->references('idactivo')->on('activos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idestado_inicial', 'fk_ot_retiros_estados1')->references('idestado')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idestado_final', 'fk_ot_retiros_estados2')->references('idestado')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idestado_ot', 'fk_ot_retiros_estados3')->references('idestado')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idreporte_retiro', 'fk_ot_retiros_reporte_retiros1')->references('idreporte_retiro')->on('reporte_retiros')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ot_retiros', function(Blueprint $table)
		{
			$table->dropForeign('fk_orden_trabajo_retiro_servicios_users1');
			$table->dropForeign('fk_orden_trabajo_retiro_servicios_users2');
			$table->dropForeign('fk_ot_retiros_ubicacion_fisicas1');
			$table->dropForeign('fk_ot_retiros_servicios1');
			$table->dropForeign('fk_ot_retiros_activos1');
			$table->dropForeign('fk_ot_retiros_estados1');
			$table->dropForeign('fk_ot_retiros_estados2');
			$table->dropForeign('fk_ot_retiros_estados3');
			$table->dropForeign('fk_ot_retiros_reporte_retiros1');
		});
	}

}
