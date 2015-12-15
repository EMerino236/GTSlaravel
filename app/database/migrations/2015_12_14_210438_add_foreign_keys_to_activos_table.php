<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToActivosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('activos', function(Blueprint $table)
		{
			$table->foreign('idgrupo', 'fk_activos_grupos1')->references('idgrupo')->on('grupos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idservicio', 'fk_activos_servicios1')->references('idservicio')->on('servicios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idproveedor', 'fk_activos_proveedores1')->references('idproveedor')->on('proveedores')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idreporte_instalacion', 'fk_activos_reporte_instalaciones1')->references('idreporte_instalacion')->on('reporte_instalaciones')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idestado', 'fk_activos_estados1')->references('idestado')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idubicacion_fisica', 'fk_activos_ubicacion_fisicas1')->references('idubicacion_fisica')->on('ubicacion_fisicas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idmodelo_equipo', 'fk_activos_modelo_activos1')->references('idmodelo_equipo')->on('modelo_activos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('activos', function(Blueprint $table)
		{
			$table->dropForeign('fk_activos_grupos1');
			$table->dropForeign('fk_activos_servicios1');
			$table->dropForeign('fk_activos_proveedores1');
			$table->dropForeign('fk_activos_reporte_instalaciones1');
			$table->dropForeign('fk_activos_estados1');
			$table->dropForeign('fk_activos_ubicacion_fisicas1');
			$table->dropForeign('fk_activos_modelo_activos1');
		});
	}

}
