<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFksToReporteFinanciamientoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('reporte_financiamiento', function(Blueprint $table)
		{
			$table->foreign('id_categoria')->references('id')->on('proyecto_categorias');
			$table->foreign('id_servicio_clinico')->references('idservicio')->on('servicios');
			$table->foreign('id_departamento')->references('idarea')->on('areas');
			$table->foreign('id_responsable')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('reporte_financiamiento', function(Blueprint $table)
		{
			$table->dropForeign('reporte_financiamiento_id_categoria_foreign');
			$table->dropForeign('reporte_financiamiento_id_servicio_clinico_foreign');
			$table->dropForeign('reporte_financiamiento_id_departamento_foreign');
			$table->dropForeign('reporte_financiamiento_id_responsable_foreign');
		});
	}

}
