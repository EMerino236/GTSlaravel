<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAccesoriosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('accesorios', function(Blueprint $table)
		{
			$table->foreign('idmodelo_equipo', 'fk_accesorios_modelo_activos1')->references('idmodelo_equipo')->on('modelo_activos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('accesorios', function(Blueprint $table)
		{
			$table->dropForeign('fk_accesorios_modelo_activos1');
		});
	}

}
