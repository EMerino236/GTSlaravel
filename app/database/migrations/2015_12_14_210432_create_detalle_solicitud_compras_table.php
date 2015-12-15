<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetalleSolicitudComprasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('detalle_solicitud_compras', function(Blueprint $table)
		{
			$table->integer('iddetalle_solicitud_compra', true);
			$table->string('descripcion', 200);
			$table->string('modelo', 100);
			$table->string('marca', 100);
			$table->string('serie_parte', 100);
			$table->integer('cantidad');
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idsolicitud_compra')->index('fk_detalle_solicitud_compras_solicitud_compras1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('detalle_solicitud_compras');
	}

}
