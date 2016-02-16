<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReporteInvestigacionxtipoCapacitacionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reporte_investigacionxtipo_capacitacion', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('idreporte')->unsigned();
			$table->integer('idtipo')->unsigned();
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
		Schema::drop('reporte_investigacionxtipo_capacitacion');
	}

}
