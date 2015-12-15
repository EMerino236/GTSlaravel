<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDocumentospaccTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('documentospacc', function(Blueprint $table)
		{
			$table->integer('iddocumentosPAAC', true);
			$table->string('nombre', 100);
			$table->string('url', 200)->nullable();
			$table->string('nombre_archivo', 200)->nullable();
			$table->string('nombre_archivo_encriptado', 200)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idtipo_documentosPAAC')->index('fk_documentosPAAC_tipo_documentosPAAC1_idx');
			$table->integer('anho')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('documentospacc');
	}

}
