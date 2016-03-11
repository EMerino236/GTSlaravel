<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcuerdosConveniosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('acuerdos_convenios', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre',200);
			$table->date('fechafirma');
			$table->integer('duracion');
			$table->string('descripcion',200);
			$table->string('objetivo',200);
			$table->string('url', 200)->nullable();
			$table->string('nombre_archivo', 200)->nullable();
			$table->string('nombre_archivo_encriptado', 200)->nullable();
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
		Schema::drop('acuerdos_convenios');
	}

}
