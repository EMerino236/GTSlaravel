<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterActivosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('activos', function(Blueprint $table)
		{
			$table->integer('fe');
			$table->integer('ac');
			$table->integer('rm');
			$table->integer('hie');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('activos', function(Blueprint $table)
		{
			//
		});
	}

}
