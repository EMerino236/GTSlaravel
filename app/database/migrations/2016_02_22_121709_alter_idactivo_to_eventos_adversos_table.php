<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterIdactivoToEventosAdversosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('eventos_adversos', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE eventos_adversos MODIFY idactivo INTEGER NULL;');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('eventos_adversos', function(Blueprint $table)
		{
			//
		});
	}

}
