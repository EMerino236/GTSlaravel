<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoAdquisicionExpedienteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tipo_adquisicion_expediente', function(Blueprint $table)
		{
			$table->integer('idtipo_adquisicion_expediente', true);
			$table->string('nombre', 100);
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
		Schema::drop('tipo_adquisicion_expediente');
	}

}
