<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUbicacionFisicasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ubicacion_fisicas', function(Blueprint $table)
		{
			$table->integer('idubicacion_fisica', true);
			$table->string('nombre', 100);
			$table->string('descripcion', 200);
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
		Schema::drop('ubicacion_fisicas');
	}

}
