<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCotizacionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cotizaciones', function(Blueprint $table)
		{
			$table->integer('idcotizacion', true);
			$table->float('precio', 10, 0);
			$table->integer('anho')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idtipo_referencia')->index('fk_cotizaciones_tipo_referencia1_idx');
			$table->string('codigo_cotizacion', 45)->nullable();
			$table->string('enlace_seace', 200)->nullable();
			$table->string('modelo_equipo', 100)->nullable();
			$table->string('nombre_detallado', 100)->nullable();
			$table->string('url', 200)->nullable();
			$table->string('nombre_archivo', 200)->nullable();
			$table->string('nombre_archivo_encriptado', 200)->nullable();
			$table->string('nombre_equipo', 100)->nullable();
			$table->string('marca', 100)->nullable();
			$table->string('proveedor', 100)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cotizaciones');
	}

}
