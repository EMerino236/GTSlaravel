<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReporteFinanciamientoCronogramasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reporte_financiamiento_cronogramas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('descripcion');
			$table->date('fecha_ini');
			$table->date('fecha_fin');
			$table->integer('duracion');
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
		Schema::drop('reporte_financiamiento_cronogramas');
	}

}
