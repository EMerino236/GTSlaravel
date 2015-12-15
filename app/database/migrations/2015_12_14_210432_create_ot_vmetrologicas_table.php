<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOtVmetrologicasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ot_vmetrologicas', function(Blueprint $table)
		{
			$table->integer('idot_vmetrologica', true);
			$table->string('ot_tipo_abreviatura', 2)->nullable();
			$table->string('ot_correlativo', 4)->nullable();
			$table->string('ot_activo_abreviatura', 2)->nullable();
			$table->integer('numero_ficha')->nullable();
			$table->integer('idservicio')->index('fk_ot_vmetrologicas_servicios1_idx');
			$table->integer('id_usuariosolicitante')->index('fk_ot_vmetrologicas_users1_idx');
			$table->integer('id_usuarioelaborador')->nullable()->index('fk_ot_vmetrologicas_users2_idx');
			$table->integer('idactivo')->index('fk_ot_vmetrologicas_activos1_idx');
			$table->integer('idestado_inicial')->nullable()->index('fk_ot_vmetrologicas_estados1_idx');
			$table->integer('idestado_final')->nullable()->index('fk_ot_vmetrologicas_estados2_idx');
			$table->integer('idestado_ot')->index('fk_ot_vmetrologicas_estados3_idx');
			$table->integer('idubicacion_fisica')->index('fk_ot_vmetrologicas_ubicacion_fisicas1_idx');
			$table->dateTime('fecha_programacion')->nullable();
			$table->dateTime('fecha_conformidad')->nullable();
			$table->float('costo_total', 10, 0)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->string('nombre_ejecutor', 200)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ot_vmetrologicas');
	}

}
