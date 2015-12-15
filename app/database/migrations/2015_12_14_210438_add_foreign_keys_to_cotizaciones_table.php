<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCotizacionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cotizaciones', function(Blueprint $table)
		{
			$table->foreign('idtipo_referencia', 'fk_cotizaciones_tipo_referencia1')->references('idtipo_referencia')->on('tipo_referencia')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cotizaciones', function(Blueprint $table)
		{
			$table->dropForeign('fk_cotizaciones_tipo_referencia1');
		});
	}

}
