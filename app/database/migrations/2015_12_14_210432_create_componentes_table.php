<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComponentesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('componentes', function(Blueprint $table)
		{
			$table->integer('idcomponente', true);
			$table->string('numero_pieza', 45);
			$table->string('nombre', 45);
			$table->string('modelo', 45);
			$table->float('costo', 10, 0);
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idmodelo_equipo')->index('fk_componentes_modelo_activos1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('componentes');
	}

}
