<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDocumentosinfTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('documentosinf', function(Blueprint $table)
		{
			$table->integer('iddocumentosinf', true);
			$table->string('nombre', 100);
			$table->string('descripcion', 150)->nullable();
			$table->string('autor', 100);
			$table->string('codigo_archivamiento', 100);
			$table->string('ubicacion', 100);
			$table->string('url', 200)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->string('nombre_archivo', 200)->nullable();
			$table->string('nombre_archivo_encriptado', 200)->nullable();
			$table->integer('idtipo_documentosinf')->index('fk_documentosinf_tipo_documentosinf1_idx');
			$table->integer('idestado')->index('fk_documentosinf_estados1_idx');
			$table->integer('idfamilia_activo')->nullable()->index('fk_documentosinf_familia_activos1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('documentosinf');
	}

}
