<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFamiliaActivosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('familia_activos', function(Blueprint $table)
		{
			$table->integer('idfamilia_activo', true);
			$table->string('nombre_equipo', 100);
			$table->string('nombre_siga', 100);
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idtipo_activo')->index('fk_familia_activos_tipo_activos1_idx');
			$table->integer('idmarca')->index('fk_familia_activos_marcas1_idx');
			$table->integer('idestado')->index('fk_familia_activos_estados1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('familia_activos');
	}

}
