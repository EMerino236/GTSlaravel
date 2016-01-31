<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReporteFinanciamientoInversionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reporte_financiamiento_inversiones', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('descripcion');
			$table->float('costo');
			$table->integer('id_reporte')->unsigned();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('reporte_financiamiento_inversiones');
	}

}
