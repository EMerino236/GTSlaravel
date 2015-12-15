<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOtInspecEquiposTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ot_inspec_equipos', function(Blueprint $table)
		{
			$table->integer('idot_inspec_equipo', true);
			$table->string('ot_tipo_abreviatura', 3)->nullable();
			$table->string('ot_correlativo', 4)->nullable();
			$table->integer('numero_ficha')->nullable();
			$table->dateTime('fecha_inicio')->nullable();
			$table->dateTime('fecha_fin')->nullable();
			$table->integer('idestado')->index('fk_ot_inspec_equipos_estados1_idx');
			$table->integer('idubicacion_fisica')->nullable()->index('fk_ot_inspec_equipos_ubicacion_fisicas1_idx');
			$table->integer('idservicio')->index('fk_ot_inspec_equipos_servicios1_idx');
			$table->integer('id_ingeniero')->index('fk_ot_inspec_equipos_users1_idx');
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
		Schema::drop('ot_inspec_equipos');
	}

}
