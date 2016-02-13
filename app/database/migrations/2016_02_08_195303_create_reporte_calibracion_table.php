<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReporteCalibracionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reporte_calibracion', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('codigo_abreviatura',2);
			$table->string('codigo_correlativo',4);
			$table->string('codigo_anho',2);
			$table->integer('idactivo');
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
		Schema::drop('reporte_calibracion');
	}

}
