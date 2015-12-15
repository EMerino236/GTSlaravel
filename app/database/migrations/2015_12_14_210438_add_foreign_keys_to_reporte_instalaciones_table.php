<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToReporteInstalacionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('reporte_instalaciones', function(Blueprint $table)
		{
			$table->foreign('idtipo_reporte_instalacion', 'fk_reporte_instalaciones_tipo_reporte_instalaciones1')->references('idtipo_reporte_instalacion')->on('tipo_reporte_instalaciones')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idestado', 'fk_reporte_instalaciones_estados1')->references('idestado')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_responsable', 'fk_reporte_instalaciones_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idproveedor', 'fk_reporte_instalaciones_proveedores1')->references('idproveedor')->on('proveedores')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idarea', 'fk_reporte_instalaciones_areas1')->references('idarea')->on('areas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idreporte_instalacion_entorno_concluido', 'fk_reporte_instalaciones_reporte_instalaciones1')->references('idreporte_instalacion')->on('reporte_instalaciones')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('reporte_instalaciones', function(Blueprint $table)
		{
			$table->dropForeign('fk_reporte_instalaciones_tipo_reporte_instalaciones1');
			$table->dropForeign('fk_reporte_instalaciones_estados1');
			$table->dropForeign('fk_reporte_instalaciones_users1');
			$table->dropForeign('fk_reporte_instalaciones_proveedores1');
			$table->dropForeign('fk_reporte_instalaciones_areas1');
			$table->dropForeign('fk_reporte_instalaciones_reporte_instalaciones1');
		});
	}

}
