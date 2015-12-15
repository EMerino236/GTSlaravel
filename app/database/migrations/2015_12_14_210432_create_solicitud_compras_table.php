<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSolicitudComprasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('solicitud_compras', function(Blueprint $table)
		{
			$table->integer('idsolicitud_compra', true);
			$table->string('codigo_ot', 10)->nullable();
			$table->integer('idtipo_solicitud_compra')->index('fk_solicitud_compras_tipo_solicitud_compras1_idx');
			$table->integer('idfamilia_activo')->nullable()->index('fk_solicitud_compras_familia_activos1_idx');
			$table->dateTime('fecha')->nullable();
			$table->string('sustento', 500)->nullable();
			$table->integer('idservicio')->index('fk_solicitud_compras_servicios1_idx');
			$table->timestamps();
			$table->softDeletes();
			$table->integer('id_responsable')->index('fk_solicitud_compras_users1_idx');
			$table->integer('idestado')->index('fk_solicitud_compras_estados1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('solicitud_compras');
	}

}
