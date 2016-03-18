<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToSesionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('sesiones', function(Blueprint $table)
		{
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
		Schema::table('sesiones', function(Blueprint $table)
		{
			$table->dropForeign('sesiones_id_capacitacion_foreign');
		});
	}

}
