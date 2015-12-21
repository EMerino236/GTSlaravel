<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkIdTipoPadreToDocumentosinfTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('documentosinf', function(Blueprint $table)
		{
			$table->integer('id_tipo_padre')->unsigned()->nullable();
			$table->foreign('id_tipo_padre')->references('id')->on('tipo_documentosinf_padre');
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
			$table->dropForeign('documentosinf_id_tipo_padre_foreign');
		});
	}

}
