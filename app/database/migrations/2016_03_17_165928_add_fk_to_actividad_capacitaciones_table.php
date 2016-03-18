<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToActividadCapacitacionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('actividad_capacitaciones', function(Blueprint $table)
		{
			$table->foreign('id_servicio')->references('idservicio')->on('servicios');	
			$table->foreign('id_sesion')->references('id')->on('sesiones');	
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('actividad_capacitaciones', function(Blueprint $table)
		{
			$table->dropForeign('actividad_capacitaciones_id_servicio_foreign');
			$table->dropForeign('actividad_capacitaciones_id_sesion_foreign');
		});
	}

}
