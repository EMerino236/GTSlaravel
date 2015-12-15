<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTipoDocumentosinfTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tipo_documentosinf', function(Blueprint $table)
		{
			$table->integer('idtipo_documentosinf', true);
			$table->string('nombre', 100)->nullable();
			$table->string('descripcion', 200)->nullable();
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
		Schema::drop('tipo_documentosinf');
	}

}
