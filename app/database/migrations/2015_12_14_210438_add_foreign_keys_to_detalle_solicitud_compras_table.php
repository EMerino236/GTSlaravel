<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDetalleSolicitudComprasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('detalle_solicitud_compras', function(Blueprint $table)
		{
			$table->foreign('idsolicitud_compra', 'fk_detalle_solicitud_compras_solicitud_compras1')->references('idsolicitud_compra')->on('solicitud_compras')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('detalle_solicitud_compras', function(Blueprint $table)
		{
			$table->dropForeign('fk_detalle_solicitud_compras_solicitud_compras1');
		});
	}

}
