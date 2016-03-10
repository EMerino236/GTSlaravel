<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterIdservicioToProgramacionCompraAdquisicionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('programacion_compra_adquisicion', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE programacion_compra_adquisicion MODIFY idservicio INTEGER NULL;');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('programacion_compra_adquisicion', function(Blueprint $table)
		{
			//
		});
	}

}
