<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTareasOtCorrectivosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tareas_ot_correctivos', function(Blueprint $table)
		{
			$table->integer('idtareas_ot_correctivo', true);
			$table->string('nombre', 100)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idot_correctivo')->index('fk_tareas_ot_correctivos_ot_correctivos1_idx');
			$table->integer('idestado_realizado')->index('fk_tareas_ot_correctivos_estados1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tareas_ot_correctivos');
	}

}
