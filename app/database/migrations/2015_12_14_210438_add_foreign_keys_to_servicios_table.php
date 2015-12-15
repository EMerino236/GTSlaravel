<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToServiciosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('servicios', function(Blueprint $table)
		{
			$table->foreign('idtipo_servicios', 'fk_servicios_tipo_servicios1')->references('idtipo_servicios')->on('tipo_servicios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idarea', 'fk_servicios_areas1')->references('idarea')->on('areas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idestado', 'fk_servicios_estados1')->references('idestado')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_usuario_responsable', 'fk_servicios_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('servicios', function(Blueprint $table)
		{
			$table->dropForeign('fk_servicios_tipo_servicios1');
			$table->dropForeign('fk_servicios_areas1');
			$table->dropForeign('fk_servicios_estados1');
			$table->dropForeign('fk_servicios_users1');
		});
	}

}
