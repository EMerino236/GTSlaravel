<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableReportesDesarolloIndicadores extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reportes_desarrollo_indicadores', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->string('base');
			$table->string('unidad');
			$table->string('definicion');
			$table->string('medio');
			$table->integer('reporte_id')->unsigned();
			$table->integer('dimension_id')->unsigned();
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
		Schema::drop('reportes_desarrollo_indicadores');
	}

}
