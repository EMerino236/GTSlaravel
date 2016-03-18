<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterIdActivoToCapacitacionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('capacitaciones', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE capacitaciones MODIFY id_activo INTEGER NULL;');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('capacitaciones', function(Blueprint $table)
		{
			//
		});
	}

}
