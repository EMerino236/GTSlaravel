<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToTareasInspecEquiposTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tareas_inspec_equipos', function(Blueprint $table)
		{
			$table->integer('borrado_por')->nullable();
			$table->foreign('borrado_por')->references('id')->on('users');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tareas_inspec_equipos', function(Blueprint $table)
		{
			$table->dropForeign('tareas_inspec_equipos_borrado_por_foreign');
		});
	}

}
