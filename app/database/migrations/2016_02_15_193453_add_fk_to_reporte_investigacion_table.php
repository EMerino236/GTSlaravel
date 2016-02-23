<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToReporteInvestigacionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('reporte_investigacion', function(Blueprint $table)
		{
			$table->foreign('idevento_adverso')->references('id')->on('eventos_adversos');
			$table->foreign('idusuario_elaborador')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('reporte_investigacion', function(Blueprint $table)
		{
			$table->dropForeign('reporte_investigacion_idevento_adverso_foreign');
			$table->dropForeign('reporte_investigacion_idusuario_elaborador_foreign');
		});
	}

}
