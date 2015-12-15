<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTipoSolicitudComprasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tipo_solicitud_compras', function(Blueprint $table)
		{
			$table->integer('idtipo_solicitud_compra', true);
			$table->string('nombre', 45);
			$table->string('descripcion', 100)->nullable();
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
		Schema::drop('tipo_solicitud_compras');
	}

}
