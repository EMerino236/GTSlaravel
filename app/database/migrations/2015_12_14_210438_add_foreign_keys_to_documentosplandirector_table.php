<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDocumentosplandirectorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('documentosplandirector', function(Blueprint $table)
		{
			$table->foreign('idtipo_documentosPlanDirector', 'fk_documentosPAAC_copy1_tipo_documentosPlanDirector1')->references('idtipo_documentosPlanDirector')->on('tipo_documentosplandirector')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('documentosplandirector', function(Blueprint $table)
		{
			$table->dropForeign('fk_documentosPAAC_copy1_tipo_documentosPlanDirector1');
		});
	}

}
