<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConsumiblesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('consumibles', function(Blueprint $table)
		{
			$table->integer('idconsumible', true);
			$table->string('nombre', 100);
			$table->integer('cantidad');
			$table->float('costo', 10, 0);
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idmodelo_equipo')->index('fk_consumibles_modelo_activos1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('consumibles');
	}

}
