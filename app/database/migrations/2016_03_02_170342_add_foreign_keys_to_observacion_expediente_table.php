<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToObservacionExpedienteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('observacion_expediente', function(Blueprint $table)
		{			
			$table->foreign('idoferta_expediente','fk_observacion_expediente_oferta_expediente1_idx')->references('idoferta_expediente')->on('oferta_expediente');
			$table->foreign('iduser','fk_observacion_expediente_users1_idx')->references('id')->on('users');
			$table->foreign('idtipo_observacion_expediente','fk_observacion_expediente_tipo_observacion_expediente1_idx')->references('idtipo_observacion_expediente')->on('tipo_observacion_expediente');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('observacion_expediente', function(Blueprint $table)
		{			
			$table->dropforeign('fk_observacion_expediente_oferta_expediente1_idx');
			$table->dropforeign('fk_observacion_expediente_users1_idx');
			$table->dropforeign('fk_observacion_expediente_tipo_observacion_expediente1_idx');
		});
	}

}
