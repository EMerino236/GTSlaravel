<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTareasInspecEquiposTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tareas_inspec_equipos', function(Blueprint $table)
		{
			$table->integer('idtareas_inspec_equipo', true);
			$table->string('nombre', 100)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idfamilia_activo')->index('fk_tareas_inspec_equipos_familia_activos1_idx');
			$table->integer('creador')->index('fk_tareas_inspec_equipos_users1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tareas_inspec_equipos');
	}

}
