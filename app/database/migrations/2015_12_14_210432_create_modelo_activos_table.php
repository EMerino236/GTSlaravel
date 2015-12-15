<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateModeloActivosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('modelo_activos', function(Blueprint $table)
		{
			$table->integer('idmodelo_equipo', true);
			$table->string('nombre', 100)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idfamilia_activo')->index('fk_modelo_activos_familia_activos1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('modelo_activos');
	}

}
