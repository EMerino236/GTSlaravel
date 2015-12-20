<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToSubtipoDocumentosinfTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('subtipo_documentosinf', function(Blueprint $table)
		{
			$table->foreign('id_tipo')->references('idtipo_documentosinf')->on('tipo_documentosinf');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('subtipo_documentosinf', function(Blueprint $table)
		{
			$table->dropForeign('subtipo_documentosinf_id_tipo_foreign');
		});
	}

}
