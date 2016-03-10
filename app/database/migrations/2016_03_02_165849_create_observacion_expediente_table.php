<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObservacionExpedienteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('observacion_expediente', function(Blueprint $table)
		{
			$table->integer('idobservacion_expediente', true);			
			$table->integer('idoferta_expediente')->index('fk_observacion_expediente_oferta_expediente1_idx');
			$table->integer('iduser')->index('fk_observacion_expediente_users1_idx');
			$table->integer('tipo_miembro');//1:Presidente, 2:Miembro1, 3:Miembro2, 4:Miembro3
			$table->string('descripcion',255);
			$table->integer('idtipo_observacion_expediente')->index('fk_observacion_expediente_tipo_observacion_expediente1_idx');
			$table->string('url', 200)->nullable();
			$table->string('nombre_archivo', 200)->nullable();
			$table->string('nombre_archivo_encriptado', 200)->nullable();
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
		Schema::drop('observacion_expediente');
	}

}
