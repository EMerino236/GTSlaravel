<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToEventoxentornoAsistencial extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('eventoxentorno_asistencial', function(Blueprint $table)
		{
			$table->foreign('identorno')->references('id')->on('entorno_asistencial');
			$table->foreign('idevento')->references('id')->on('eventos_adversos');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('eventoxentorno_asistencial', function(Blueprint $table)
		{
			$table->dropForeign('eventoxentorno_asistencial_identorno_foreign');
			$table->dropForeign('eventoxentorno_asistencial_idevento_foreign');
		});
	}

}
