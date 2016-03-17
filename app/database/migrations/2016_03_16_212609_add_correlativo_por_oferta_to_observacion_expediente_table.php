<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCorrelativoPorOfertaToObservacionExpedienteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('observacion_expediente', function(Blueprint $table)
		{
			$table->integer('correlativo_por_oferta');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('observacion_expediente', function(Blueprint $table)
		{
			//
		});
	}

}
