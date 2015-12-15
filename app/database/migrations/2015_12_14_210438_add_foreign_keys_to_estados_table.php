<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEstadosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('estados', function(Blueprint $table)
		{
			$table->foreign('idtabla', 'fk_estados_tablas1')->references('idtabla')->on('tablas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('estados', function(Blueprint $table)
		{
			$table->dropForeign('fk_estados_tablas1');
		});
	}

}
