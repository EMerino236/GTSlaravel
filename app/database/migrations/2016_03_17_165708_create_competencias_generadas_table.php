<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetenciasGeneradasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('competencias_generadas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre',100);
			$table->string('indicador',100);
			$table->integer('id_sesion')->unsigned();
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
		Schema::drop('competencias_generadas');
	}

}
