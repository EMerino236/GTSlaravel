<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubtipoDocumentosinfTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subtipo_documentosinf', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre', 100)->nullable();
			$table->string('descripcion', 200)->nullable();
			$table->integer('id_tipo');
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
		Schema::drop('subtipo_documentosinf');
	}

}
