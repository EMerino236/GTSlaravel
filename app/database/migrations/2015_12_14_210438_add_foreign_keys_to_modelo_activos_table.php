<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToModeloActivosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('modelo_activos', function(Blueprint $table)
		{
			$table->foreign('idfamilia_activo', 'fk_modelo_activos_familia_activos1')->references('idfamilia_activo')->on('familia_activos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('modelo_activos', function(Blueprint $table)
		{
			$table->dropForeign('fk_modelo_activos_familia_activos1');
		});
	}

}
