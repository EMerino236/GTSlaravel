<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkIdTipoPadreToTipoDocumentosinfTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tipo_documentosinf', function(Blueprint $table)
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
		Schema::table('tipo_documentosinf', function(Blueprint $table)
		{
			$table->dropForeign('tipo_documentosinf_id_tipo_padre_foreign');
		});
	}

}
