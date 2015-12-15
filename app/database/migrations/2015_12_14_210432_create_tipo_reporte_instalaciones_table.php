<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTipoReporteInstalacionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tipo_reporte_instalaciones', function(Blueprint $table)
		{
			$table->integer('idtipo_reporte_instalacion', true);
			$table->string('nombre', 100);
			$table->string('descripcion', 200)->nullable();
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
		Schema::drop('tipo_reporte_instalaciones');
	}

}
