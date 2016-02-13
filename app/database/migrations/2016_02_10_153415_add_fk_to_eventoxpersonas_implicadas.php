<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToEventoxpersonasImplicadas extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('eventoxpersonas_implicadas', function(Blueprint $table)
		{
			$table->foreign('idevento')->references('id')->on('eventos_adversos');
			$table->foreign('idpersonas_implicada')->references('id')->on('personas_implicadas');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('eventoxpersonas_implicadas', function(Blueprint $table)
		{
			$table->dropForeign('eventoxpersonas_implicadas_idevento_foreign');
			$table->dropForeign('eventoxpersonas_implicadas_idpersonas_implicada_foreign');
		});
	}

}
