<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToPersonalCapacitacionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('personal_capacitaciones', function(Blueprint $table)
		{
			$table->foreign('id_servicio')->references('idservicio')->on('servicios');	
			$table->foreign('id_tipodocumento')->references('idtipo_documento')->on('tipo_doc_identidades');	
			$table->foreign('id_capacitacion')->references('id')->on('capacitaciones');	
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('personal_capacitaciones', function(Blueprint $table)
		{
			$table->dropForeign('personal_capacitaciones_id_servicio_foreign');
			$table->dropForeign('personal_capacitaciones_id_tipodocumento_foreign');
			$table->dropForeign('personal_capacitaciones_id_capacitacion_foreign');
		});
	}

}
