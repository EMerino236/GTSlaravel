<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTiempoMaximoToTipoSolicitudCompras extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tipo_solicitud_compras', function(Blueprint $table)
		{
			$table->integer('tiempo_maximo')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tipo_solicitud_compras', function(Blueprint $table)
		{
			//
		});
	}

}
