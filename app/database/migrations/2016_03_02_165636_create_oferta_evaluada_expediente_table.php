<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfertaEvaluadaExpedienteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('oferta_evaluada_expediente', function(Blueprint $table)
		{
			$table->integer('idoferta_evaluada_expediente', true);			
			$table->integer('idoferta_expediente')->index('fk_oferta_evaluada_expediente_oferta_expediente1_idx');
			$table->integer('iduser')->index('fk_oferta_evaluada_expediente_users1_idx');
			$table->integer('tipo_miembro');//1:Presidente, 2:Miembro1, 3:Miembro2, 4:Miembro3
			$table->string('evaluacion',500);
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
		Schema::drop('oferta_evaluada_expediente');
	}

}
