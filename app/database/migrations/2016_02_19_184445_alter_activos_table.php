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
			$table->integer('ge')->after('idmodelo_equipo');
			$table->integer('hie')->after('idmodelo_equipo');
			$table->integer('rm')->after('idmodelo_equipo');
			$table->integer('ac')->after('idmodelo_equipo');
			$table->integer('fe')->after('idmodelo_equipo');
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
