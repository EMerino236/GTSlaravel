<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccesoriosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('accesorios', function(Blueprint $table)
		{
			$table->integer('idaccesorio', true);
			$table->string('numero_pieza', 45);
			$table->string('nombre', 45);
			$table->string('modelo', 45);
			$table->float('costo', 10, 0);
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idmodelo_equipo')->index('fk_accesorios_modelo_activos1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('accesorios');
	}

}
