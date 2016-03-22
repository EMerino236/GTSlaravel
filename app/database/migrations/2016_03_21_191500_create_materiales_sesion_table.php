<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialesSesionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('materiales_sesion', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('infraestructura',500);
			$table->string('equipos',500);
			$table->string('herramientas',500);
			$table->string('insumos',500);
			$table->string('equipopersonal',500);
			$table->string('condicionesseguridad',500);
			$table->integer('idsesion')->unsigned();
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
		Schema::drop('materiales_sesion');
	}

}
