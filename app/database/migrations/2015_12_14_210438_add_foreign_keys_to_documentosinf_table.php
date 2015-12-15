<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDocumentosinfTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('documentosinf', function(Blueprint $table)
		{
			$table->foreign('idtipo_documentosinf', 'fk_documentosinf_tipo_documentosinf1')->references('idtipo_documentosinf')->on('tipo_documentosinf')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idestado', 'fk_documentosinf_estados1')->references('idestado')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idfamilia_activo', 'fk_documentosinf_familia_activos1')->references('idfamilia_activo')->on('familia_activos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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
			$table->dropForeign('fk_documentosinf_tipo_documentosinf1');
			$table->dropForeign('fk_documentosinf_estados1');
			$table->dropForeign('fk_documentosinf_familia_activos1');
		});
	}

}
