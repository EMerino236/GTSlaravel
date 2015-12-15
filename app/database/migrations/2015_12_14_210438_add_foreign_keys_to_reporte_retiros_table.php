<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToReporteRetirosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('reporte_retiros', function(Blueprint $table)
		{
			$table->foreign('idactivo', 'fk_reporte_retiros_activos1')->references('idactivo')->on('activos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idmotivo_retiro', 'fk_reporte_retiros_motivo_retiros1')->references('idmotivo_retiro')->on('motivo_retiros')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('reporte_retiros', function(Blueprint $table)
		{
			$table->dropForeign('fk_reporte_retiros_activos1');
			$table->dropForeign('fk_reporte_retiros_motivo_retiros1');
		});
	}

}
