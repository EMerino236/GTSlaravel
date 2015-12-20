<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToDocumentosinfTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('documentosinf', function(Blueprint $table)
		{
			$table->integer('id_subtipo')->unsigned()->nullable();
			$table->foreign('id_subtipo')->references('id')->on('subtipo_documentosinf');
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
			$table->dropForeign('documentosinf_id_subtipo_foreign');
		});
	}

}
