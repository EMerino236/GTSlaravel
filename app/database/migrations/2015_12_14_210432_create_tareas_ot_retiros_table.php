<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTareasOtRetirosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tareas_ot_retiros', function(Blueprint $table)
		{
			$table->integer('idtareas_ot_retiro', true);
			$table->string('nombre', 200);
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idot_retiro')->index('fk_tareas_ot_retiros_ot_retiros1_idx');
			$table->integer('idestado_realizado')->index('fk_tareas_ot_retiros_estados1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tareas_ot_retiros');
	}

}
