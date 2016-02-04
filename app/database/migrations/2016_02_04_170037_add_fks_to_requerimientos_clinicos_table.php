<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFksToRequerimientosClinicosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('requerimientos_clinicos', function(Blueprint $table)
		{
			$table->foreign('id_categoria')->references('id')->on('proyecto_categorias');
			$table->foreign('id_servicio_clinico')->references('idservicio')->on('servicios');
			$table->foreign('id_departamento')->references('idarea')->on('areas');
			$table->foreign('id_responsable')->references('id')->on('users');
			$table->foreign('id_estado')->references('id')->on('requerimientos_clinicos_estados');
			$table->foreign('id_reporte')->references('id')->on('reporte_financiamiento');
			$table->foreign('id_modificador')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('requerimientos_clinicos', function(Blueprint $table)
		{
			$table->dropForeign('requerimientos_clinicos_id_categoria_foreign');
			$table->dropForeign('requerimientos_clinicos_id_servicio_clinico_foreign');
			$table->dropForeign('requerimientos_clinicos_id_departamento_foreign');
			$table->dropForeign('requerimientos_clinicos_id_responsable_foreign');
			$table->dropForeign('requerimientos_clinicos_id_estado_foreign');
			$table->dropForeign('requerimientos_clinicos_id_reporte_foreign');
			$table->dropForeign('requerimientos_clinicos_id_modificador_foreign');
		});
	}

}
