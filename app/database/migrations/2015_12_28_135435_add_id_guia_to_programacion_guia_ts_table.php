<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdGuiaToProgramacionGuiaTsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('programacion_guia_ts', function(Blueprint $table)
		{
			$table->integer('id_guia')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('programacion_guia_ts', function(Blueprint $table)
		{
			//
		});
	}

}
