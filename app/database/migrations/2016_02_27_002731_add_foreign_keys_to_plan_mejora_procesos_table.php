<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToPlanMejoraProcesosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('plan_mejora_procesos', function(Blueprint $table)
		{
			$table->foreign('idtipo_documento', 'fk_plan_mejora_procesos_tipo_documentos1')->references('idtipo_documento')->on('tipo_documentos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('plan_mejora_procesos', function(Blueprint $table)
		{
			$table->dropForeign('fk_plan_mejora_procesos_tipo_documentos1');
		});
	}

}
