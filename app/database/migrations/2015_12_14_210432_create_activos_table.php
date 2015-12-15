<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActivosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activos', function(Blueprint $table)
		{
			$table->integer('idactivo', true);
			$table->string('codigo_patrimonial', 100);
			$table->string('numero_serie', 100);
			$table->date('anho_adquisicion');
			$table->integer('garantia');
			$table->float('costo', 10, 0)->nullable();
			$table->string('codigo_compra', 100)->nullable();
			$table->integer('idgrupo')->index('fk_activos_grupos1_idx');
			$table->integer('idservicio')->index('fk_activos_servicios1_idx');
			$table->integer('idproveedor')->index('fk_activos_proveedores1_idx');
			$table->integer('idreporte_instalacion')->index('fk_activos_reporte_instalaciones1_idx');
			$table->integer('idubicacion_fisica')->index('fk_activos_ubicacion_fisicas1_idx');
			$table->integer('idmodelo_equipo')->index('fk_activos_modelo_activos1_idx');
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idestado')->index('fk_activos_estados1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('activos');
	}

}
