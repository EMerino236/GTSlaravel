<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSoporteTecnicosxactivosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('soporte_tecnicosxactivos', function(Blueprint $table)
		{
			$table->foreign('idsoporte_tecnico', 'fk_soporte_tecnicos_has_activos_soporte_tecnicos1')->references('idsoporte_tecnico')->on('soporte_tecnicos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idactivo', 'fk_soporte_tecnicos_has_activos_activos1')->references('idactivo')->on('activos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idestado', 'fk_soporte_tecnicosxactivos_estados1')->references('idestado')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('soporte_tecnicosxactivos', function(Blueprint $table)
		{
			$table->dropForeign('fk_soporte_tecnicos_has_activos_soporte_tecnicos1');
			$table->dropForeign('fk_soporte_tecnicos_has_activos_activos1');
			$table->dropForeign('fk_soporte_tecnicosxactivos_estados1');
		});
	}

}
