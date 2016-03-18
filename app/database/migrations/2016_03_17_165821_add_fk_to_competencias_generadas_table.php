<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToCompetenciasGeneradasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('competencias_generadas', function(Blueprint $table)
		{
			$table->foreign('id_sesion')->references('id')->on('sesiones');			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('competencias_generadas', function(Blueprint $table)
		{
			$table->dropForeign('competencias_generadas_id_sesion_foreign');		
		});
	}

}
