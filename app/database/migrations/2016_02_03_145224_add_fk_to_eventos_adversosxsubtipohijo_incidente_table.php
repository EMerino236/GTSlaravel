<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToEventosAdversosxsubtipohijoIncidenteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('eventos_adversosxsubtipohijo_incidente', function(Blueprint $table)
		{
			$table->foreign('idevento')->references('id')->on('eventos_adversos');
			$table->foreign('idsubtipohijo')->references('id')->on('subtipohijo_incidente');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('eventos_adversosxsubtipohijo_incidente', function(Blueprint $table)
		{
			$table->dropForeign('eventos_adversosxsubtipohijo_incidente_idevento_foreign');
			$table->dropForeign('eventos_adversosxsubtipohijo_incidente_idsubtipohijo_foreign');
		});
	}

}
