<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToSubtipohijoIncidenteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('subtipohijo_incidente', function(Blueprint $table)
		{
			$table->foreign('idsubtipopadre_incidente')->references('id')->on('subtipopadre_incidente');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('subtipohijo_incidente', function(Blueprint $table)
		{
			$table->dropForeign('subtipohijo_incidente_idsubtipopadre_incidente_foreign');
		});
	}

}
