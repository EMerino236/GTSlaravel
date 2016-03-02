<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToProgramacionCompraAdquisicionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('programacion_compra_adquisicion', function(Blueprint $table)
		{
			$table->foreign('idarea', 'fk_programacion_compra_adquisicion_areas1')->references('idarea')->on('areas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idservicio', 'fk_programacion_compra_adquisicion_servicios1')->references('idservicio')->on('servicios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('iduser', 'fk_programacion_compra_adquisicion_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idresponsable', 'fk_programacion_compra_adquisicion_users2')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idtipo_compra', 'fk_programacion_compra_adquisicion_tipo_compra1')->references('idtipo_compra')->on('tipo_compra')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idunidad_medida', 'fk_programacion_compra_adquisicion_unidad_medida1')->references('idunidad_medida')->on('unidad_medida')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('programacion_compra_adquisicion', function(Blueprint $table)
		{
			$table->dropForeign('fk_programacion_compra_adquisicion_areas1');
			$table->dropForeign('fk_programacion_compra_adquisicion_servicios1');
			$table->dropForeign('fk_programacion_compra_adquisicion_users1');
			$table->dropForeign('fk_programacion_compra_adquisicion_users2');
			$table->dropForeign('fk_programacion_compra_adquisicion_tipo_compra1');
			$table->dropForeign('fk_programacion_compra_adquisicion_unidad_medida1');
		});
	}

}
