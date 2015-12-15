<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOtInspecEquiposTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ot_inspec_equipos', function(Blueprint $table)
		{
			$table->foreign('idestado', 'fk_ot_inspec_equipos_estados1')->references('idestado')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idubicacion_fisica', 'fk_ot_inspec_equipos_ubicacion_fisicas1')->references('idubicacion_fisica')->on('ubicacion_fisicas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idservicio', 'fk_ot_inspec_equipos_servicios1')->references('idservicio')->on('servicios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_ingeniero', 'fk_ot_inspec_equipos_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ot_inspec_equipos', function(Blueprint $table)
		{
			$table->dropForeign('fk_ot_inspec_equipos_estados1');
			$table->dropForeign('fk_ot_inspec_equipos_ubicacion_fisicas1');
			$table->dropForeign('fk_ot_inspec_equipos_servicios1');
			$table->dropForeign('fk_ot_inspec_equipos_users1');
		});
	}

}
