<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTareasOtRetirosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tareas_ot_retiros', function(Blueprint $table)
		{
			$table->foreign('idot_retiro', 'fk_tareas_ot_retiros_ot_retiros1')->references('idot_retiro')->on('ot_retiros')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idestado_realizado', 'fk_tareas_ot_retiros_estados1')->references('idestado')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tareas_ot_retiros', function(Blueprint $table)
		{
			$table->dropForeign('fk_tareas_ot_retiros_ot_retiros1');
			$table->dropForeign('fk_tareas_ot_retiros_estados1');
		});
	}

}
