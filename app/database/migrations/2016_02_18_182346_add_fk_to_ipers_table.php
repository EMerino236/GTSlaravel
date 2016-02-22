<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToIpersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ipers', function(Blueprint $table)
		{
			$table->foreign('idusuario_elaborador')->references('id')->on('users');
			$table->foreign('idservicio')->references('idservicio')->on('servicios');
			$table->foreign('identorno_asistencial')->references('id')->on('entorno_asistencial');
			$table->foreign('idtipo_iper')->references('id')->on('tipo_iper');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ipers', function(Blueprint $table)
		{
			$table->dropForeign('iper_idusuario_elaborador_foreign');
			$table->dropForeign('iper_idservicio_foreign');
			$table->dropForeign('iper_identorno_asistencial_foreign');
			$table->dropForeign('iper_idtipo_iper_foreign');
		});
	}

}
