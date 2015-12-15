<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDocumentosplandirectorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('documentosplandirector', function(Blueprint $table)
		{
			$table->integer('iddocumentosPlanDirector', true);
			$table->string('nombre', 100);
			$table->string('url', 200)->nullable();
			$table->string('nombre_archivo', 200)->nullable();
			$table->string('nombre_archivo_encriptado', 200)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idtipo_documentosPlanDirector')->index('fk_documentosPAAC_copy1_tipo_documentosPlanDirector1_idx');
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
		Schema::drop('documentosplandirector');
	}

}
