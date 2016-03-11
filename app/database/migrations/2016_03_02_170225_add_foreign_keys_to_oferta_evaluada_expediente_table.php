<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToOfertaEvaluadaExpedienteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('oferta_evaluada_expediente', function(Blueprint $table)
		{			
			$table->foreign('idoferta_expediente','fk_oferta_evaluada_expediente_oferta_expediente1_idx')->references('idoferta_expediente')->on('oferta_expediente');
			$table->foreign('iduser','fk_oferta_evaluada_expediente_users1_idx')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('oferta_evaluada_expediente', function(Blueprint $table)
		{			
			$table->dropforeign('fk_oferta_evaluada_expediente_oferta_expediente1_idx');
			$table->dropforeign('fk_oferta_evaluada_expediente_users1_idx');
		});
	}

}
