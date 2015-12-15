<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPersonalOtBusquedaInfosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('personal_ot_busqueda_infos', function(Blueprint $table)
		{
			$table->foreign('idot_busqueda_info', 'fk_personal_ot_busqueda_infos_ot_busqueda_infos1')->references('idot_busqueda_info')->on('ot_busqueda_infos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('personal_ot_busqueda_infos', function(Blueprint $table)
		{
			$table->dropForeign('fk_personal_ot_busqueda_infos_ot_busqueda_infos1');
		});
	}

}
