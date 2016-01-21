<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullableIdProgramacionToDocumentosinfTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('documentosinf', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE documentosinf MODIFY id_programacion INTEGER UNSIGNED NULL;');
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
