<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReporteInvestigacionxmetodoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reporte_investigacionxmetodo', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('idreporte')->unsigned();
			$table->integer('idmetodo')->unsigned();
			$table->string('nombre',200)->nullable();
			$table->string('url', 200)->nullable();
			$table->string('nombre_archivo', 200)->nullable();
			$table->string('nombre_archivo_encriptado', 200)->nullable();
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
		Schema::drop('reporte_investigacionxmetodo');
	}

}
