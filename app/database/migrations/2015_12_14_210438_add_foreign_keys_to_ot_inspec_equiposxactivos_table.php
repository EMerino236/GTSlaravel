<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOtInspecEquiposxactivosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ot_inspec_equiposxactivos', function(Blueprint $table)
		{
			$table->foreign('idot_inspec_equipo', 'fk_ot_inspec_equipos_has_activos_ot_inspec_equipos1')->references('idot_inspec_equipo')->on('ot_inspec_equipos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idactivo', 'fk_ot_inspec_equipos_has_activos_activos1')->references('idactivo')->on('activos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ot_inspec_equiposxactivos', function(Blueprint $table)
		{
			$table->dropForeign('fk_ot_inspec_equipos_has_activos_ot_inspec_equipos1');
			$table->dropForeign('fk_ot_inspec_equipos_has_activos_activos1');
		});
	}

}
