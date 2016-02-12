<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToSubtiponietoIncidenteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('subtiponieto_incidente', function(Blueprint $table)
		{
			$table->foreign('idsubtipohijo_incidente')->references('id')->on('subtipohijo_incidente');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('subtiponieto_incidente', function(Blueprint $table)
		{
			$table->dropForeign('subtiponieto_incidente_idsubtipohijo_incidente_foreign');
		});
	}

}
