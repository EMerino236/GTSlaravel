<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToEventosxhijoxnietoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('eventosxhijoxnieto', function(Blueprint $table)
		{
			$table->foreign('ideventoxhijo')->references('id')->on('eventos_adversosxsubtipohijo_incidente');
			$table->foreign('idsubtiponieto')->references('id')->on('subtiponieto_incidente');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('eventosxhijoxnieto', function(Blueprint $table)
		{
			$table->dropForeign('eventosxhijoxnieto_ideventoxhijo_foreign');
			$table->dropForeign('eventosxhijoxnieto_idsubtiponieto_foreign');
		});
	}

}
