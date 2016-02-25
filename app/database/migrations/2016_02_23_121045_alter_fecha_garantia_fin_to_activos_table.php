<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterFechaGarantiaFinToActivosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('activos', function(Blueprint $table)
		{
			$table->date('fecha_garantia_fin')->after('garantia');			
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
