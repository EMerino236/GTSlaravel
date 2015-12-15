<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOtCorrectivosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ot_correctivos', function(Blueprint $table)
		{
			$table->foreign('idubicacion_fisica', 'fk_ot_correctivos_ubicacion_fisicas1')->references('idubicacion_fisica')->on('ubicacion_fisicas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_usuariosolicitante', 'fk_ot_correctivos_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_usuarioelaborador', 'fk_ot_correctivos_users2')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idsolicitud_orden_trabajo', 'fk_ot_correctivos_solicitud_orden_trabajos1')->references('idsolicitud_orden_trabajo')->on('solicitud_orden_trabajos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idestado_inicial', 'fk_ot_correctivos_estados1')->references('idestado')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idestado_final', 'fk_ot_correctivos_estados2')->references('idestado')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idestado_ot', 'fk_ot_correctivos_estados3')->references('idestado')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idactivo', 'fk_ot_correctivos_activos1')->references('idactivo')->on('activos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idservicio', 'fk_ot_correctivos_servicios1')->references('idservicio')->on('servicios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idprioridad', 'fk_ot_correctivos_prioridades1')->references('idprioridad')->on('prioridades')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idtipo_falla', 'fk_ot_correctivos_tipo_fallas1')->references('idtipo_falla')->on('tipo_fallas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ot_correctivos', function(Blueprint $table)
		{
			$table->dropForeign('fk_ot_correctivos_ubicacion_fisicas1');
			$table->dropForeign('fk_ot_correctivos_users1');
			$table->dropForeign('fk_ot_correctivos_users2');
			$table->dropForeign('fk_ot_correctivos_solicitud_orden_trabajos1');
			$table->dropForeign('fk_ot_correctivos_estados1');
			$table->dropForeign('fk_ot_correctivos_estados2');
			$table->dropForeign('fk_ot_correctivos_estados3');
			$table->dropForeign('fk_ot_correctivos_activos1');
			$table->dropForeign('fk_ot_correctivos_servicios1');
			$table->dropForeign('fk_ot_correctivos_prioridades1');
			$table->dropForeign('fk_ot_correctivos_tipo_fallas1');
		});
	}

}
