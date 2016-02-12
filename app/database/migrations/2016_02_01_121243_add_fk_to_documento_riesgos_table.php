<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToDocumentoRiesgosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('documento_riesgos', function(Blueprint $table)
		{
			
			$table->foreign('id_tipo')->references('id')->on('tipo_documento_riesgos');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('documento_riesgos', function(Blueprint $table)
		{
			$table->dropForeign('documento_riesgos_id_tipo_foreign');
		});
	}

}
