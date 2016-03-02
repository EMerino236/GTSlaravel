<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanMejoraProcesosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('plan_mejora_procesos', function(Blueprint $table)
		{
			$table->integer('iddocumento', true);
			$table->string('nombre', 100);
			$table->string('descripcion', 150)->nullable();
			$table->string('autor', 100);
			$table->string('codigo_archivamiento', 100);
			$table->string('ubicacion', 100);
			$table->string('url', 200)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idtipo_documento')->index('fk_documentos_tipo_documentos1_idx');
			$table->string('nombre_archivo', 200)->nullable();
			$table->string('nombre_archivo_encriptado', 200)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('plan_mejora_procesos');
	}

}
