<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfilesFormacionesContinuasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('perfiles_formaciones_continuas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->string('centro');
			$table->integer('id_pais')->unsigned();
			$table->integer('id_perfil')->unsigned();
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
		Schema::drop('perfiles_formaciones_continuas');
	}

}
