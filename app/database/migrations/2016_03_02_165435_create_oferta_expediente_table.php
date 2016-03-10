<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfertaExpedienteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('oferta_expediente', function(Blueprint $table)
		{
			$table->integer('idoferta_expediente', true);
			$table->integer('correlativo_por_expediente');
			$table->integer('idexpediente_tecnico')->index('fk_oferta_expediente_expediente_tecnico1_idx');
			$table->integer('idproveedor')->index('fk_oferta_expediente_proveedores1_idx');
			$table->float('precio',10,2);
			$table->string('caracteristicas',255);
			$table->string('url', 200);
			$table->string('nombre_archivo', 200);
			$table->string('nombre_archivo_encriptado', 200);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('oferta_expediente');
	}

}
