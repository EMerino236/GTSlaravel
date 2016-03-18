<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToCapacitacionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('capacitaciones', function(Blueprint $table)
		{
			$table->foreign('id_tipo')->references('id')->on('rh_tipos');
			$table->foreign('id_modalidad')->references('id')->on('rh_modalidades');
			$table->foreign('id_responsable')->references('id')->on('users');
			$table->foreign('id_servicio_clinico')->references('idservicio')->on('servicios');
			$table->foreign('id_activo')->references('idactivo')->on('activos');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('capacitaciones', function(Blueprint $table)
		{
			$table->dropForeign('capacitaciones_id_tipo_foreign');
			$table->dropForeign('capacitaciones_id_modalidad_foreign');
			$table->dropForeign('capacitaciones_id_responsable_foreign');
			$table->dropForeign('capacitaciones_id_servicio_clinico_foreign');
			$table->dropForeign('capacitaciones_id_activo_foreign');
		});
	}

}
