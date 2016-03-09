<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToPlanesDifusionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('planes_difusion', function(Blueprint $table)
		{
			$table->foreign('iddepartamento')->references('idarea')->on('areas');
			$table->foreign('idservicio')->references('idservicio')->on('servicios');			
			$table->foreign('idresponsable')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('planes_difusion', function(Blueprint $table)
		{
			$table->dropForeign('planes_difusion_iddepartamento_foreign');
			$table->dropForeign('planes_difusion_idservicio_foreign');
			$table->dropForeign('planes_difusion_idresponsable_foreign');			
		});
	}

}
