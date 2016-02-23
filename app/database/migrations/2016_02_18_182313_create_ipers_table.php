<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIpersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ipers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('idusuario_elaborador');
			$table->integer('idservicio')->nullable();
			$table->integer('identorno_asistencial')->unsigned()->nullable();
			$table->integer('idtipo_iper')->unsigned();
			$table->string('codigo_abreviatura',4);
			$table->string('codigo_tipo',2);
			$table->string('codigo_correlativo',4);
			$table->string('codigo_anho',2);
			$table->string('periodicidad',1);
			$table->date('fecha');
			$table->softDeletes();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ipers');
	}

}
