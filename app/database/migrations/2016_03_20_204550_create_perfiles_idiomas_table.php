<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfilesIdiomasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('perfiles_idiomas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('id_nombre')->unsigned();
			$table->integer('id_lectura')->unsigned();
			$table->integer('id_conversacion')->unsigned();
			$table->integer('id_escritura')->unsigned();
			$table->integer('id_forma')->unsigned();
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
		Schema::drop('perfiles_idiomas');
	}

}
