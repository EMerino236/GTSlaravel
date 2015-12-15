<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServiciosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('servicios', function(Blueprint $table)
		{
			$table->integer('idservicio', true);
			$table->string('nombre', 45);
			$table->string('descripcion', 100)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idtipo_servicios')->index('fk_servicios_tipo_servicios1_idx');
			$table->integer('idarea')->index('fk_servicios_areas1_idx');
			$table->integer('idestado')->index('fk_servicios_estados1_idx');
			$table->integer('id_usuario_responsable')->index('fk_servicios_users1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('servicios');
	}

}
