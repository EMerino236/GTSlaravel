<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToSubtipopadreIncidenteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('subtipopadre_incidente', function(Blueprint $table)
		{
			$table->foreign('idtipo_incidente')->references('id')->on('tipo_incidente');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('subtipopadre_incidente', function(Blueprint $table)
		{
			$table->dropForeign('subtipopadre_incidente_idtipo_incidente_foreign');
		});
	}

}
