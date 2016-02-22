<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReporteInvestigacionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reporte_investigacion', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('codigo_abreviatura',2);
			$table->string('codigo_correlativo',4);
			$table->string('codigo_anho',2);
			$table->string('usuario_reportante',100);
			$table->integer('idevento_adverso')->unsigned();
			$table->string('nombre',200)->nullable();
			$table->string('url', 200)->nullable();
			$table->string('nombre_archivo', 200)->nullable();
			$table->string('nombre_archivo_encriptado', 200)->nullable();
			$table->integer('idusuario_elaborador')->nullable();
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
		Schema::drop('reporte_investigacion');
	}

}
