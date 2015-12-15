<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDocumentospaccTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('documentospacc', function(Blueprint $table)
		{
			$table->foreign('idtipo_documentosPAAC', 'fk_documentosPAAC_tipo_documentosPAAC1')->references('idtipo_documentosPAAC')->on('tipo_documentospaac')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('documentospacc', function(Blueprint $table)
		{
			$table->dropForeign('fk_documentosPAAC_tipo_documentosPAAC1');
		});
	}

}
