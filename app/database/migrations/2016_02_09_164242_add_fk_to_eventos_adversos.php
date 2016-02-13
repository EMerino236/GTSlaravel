<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToEventosAdversos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('eventos_adversos', function(Blueprint $table)
		{
			$table->foreign('idtipo_documento')->references('idtipo_documento')->on('tipo_doc_identidades');
			$table->foreign('idfrecuencia')->references('id')->on('frecuencia_incidente');
			$table->foreign('idgrado_danho')->references('id')->on('grado_danho');
			$table->foreign('idactivo')->references('idactivo')->on('activos');
			$table->foreign('idetapa_servicio')->references('id')->on('etapa_servicio');
			$table->foreign('idfactor')->references('id')->on('factores_contribuyentes');
			$table->foreign('idproceso')->references('id')->on('procesos');
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('eventos_adversos', function(Blueprint $table)
		{
			$table->dropForeign('eventos_adversos_idtipo_documento_foreign');
			$table->dropForeign('eventos_adversos_idfrecuencia_foreign');
			$table->dropForeign('eventos_adversos_idgrado_danho_foreign');
			$table->dropForeign('eventos_adversos_idactivo_foreign');
			$table->dropForeign('eventos_adversos_idfactor_foreign');
			$table->dropForeign('eventos_adversos_idetapa_servicio_foreign');
			$table->dropForeign('eventos_adversos_idproceso_foreign');
		});
	}

}
