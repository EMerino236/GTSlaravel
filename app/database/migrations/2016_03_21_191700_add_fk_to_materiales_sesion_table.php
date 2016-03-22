<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToMaterialesSesionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('materiales_sesion', function(Blueprint $table)
		{
			$table->foreign('idsesion')->references('id')->on('sesiones');			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('materiales_sesion', function(Blueprint $table)
		{
			$table->dropForeign('materiales_sesion_idsesion_foreign');			
		});
	}

}
