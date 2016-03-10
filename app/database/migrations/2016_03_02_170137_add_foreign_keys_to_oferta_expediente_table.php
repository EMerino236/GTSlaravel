<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToOfertaExpedienteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('oferta_expediente', function(Blueprint $table)
		{
			$table->foreign('idexpediente_tecnico','fk_oferta_expediente_expediente_tecnico1_idx')->references('idexpediente_tecnico')->on('expediente_tecnico');
			$table->foreign('idproveedor','fk_oferta_expediente_proveedores1_idx')->references('idproveedor')->on('proveedores');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('oferta_expediente', function(Blueprint $table)
		{
			$table->dropforeign('fk_oferta_expediente_expediente_tecnico1_idx');
			$table->dropforeign('fk_oferta_expediente_proveedores1_idx');
		});
	}

}
