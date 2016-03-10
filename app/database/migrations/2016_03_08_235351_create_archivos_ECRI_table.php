<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchivosECRITable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('archivos_ECRI', function(Blueprint $table)
		{
			$table->integer('idarchivos_ECRI', true);
			$table->string('url', 200);
			$table->string('nombre_archivo', 200);
			$table->string('nombre_archivo_encriptado', 200);
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
		Schema::drop('archivos_ECRI');
	}

}
