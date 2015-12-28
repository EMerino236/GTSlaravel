<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdProgramacionToDocumentosinfTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('documentosinf', function(Blueprint $table)
		{
			$table->integer('id_programacion')->unsigned();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('documentosinf', function(Blueprint $table)
		{
			//
		});
	}

}
