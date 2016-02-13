<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntornoAsistencialxtipoServicioTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('entorno_asistencialxtipo_servicio', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('identorno')->unsigned();
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
		Schema::drop('entorno_asistencialxtipo_servicio');
	}

}
