<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTareasOtCorrectivosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tareas_ot_correctivos', function(Blueprint $table)
		{
			$table->foreign('idot_correctivo', 'fk_tareas_ot_correctivos_ot_correctivos1')->references('idot_correctivo')->on('ot_correctivos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idestado_realizado', 'fk_tareas_ot_correctivos_estados1')->references('idestado')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tareas_ot_correctivos', function(Blueprint $table)
		{
			$table->dropForeign('fk_tareas_ot_correctivos_ot_correctivos1');
			$table->dropForeign('fk_tareas_ot_correctivos_estados1');
		});
	}

}
