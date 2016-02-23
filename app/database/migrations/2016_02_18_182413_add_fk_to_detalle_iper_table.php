<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToDetalleIperTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('detalle_iper', function(Blueprint $table)
		{
			$table->foreign('idiper')->references('id')->on('ipers');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('detalle_iper', function(Blueprint $table)
		{
			$table->dropForeign('detalle_iper_idiper_foreign');
		});
	}

}
