<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToFamiliaActivosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('familia_activos', function(Blueprint $table)
		{
			$table->foreign('idtipo_activo', 'fk_familia_activos_tipo_activos1')->references('idtipo_activo')->on('tipo_activos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idmarca', 'fk_familia_activos_marcas1')->references('idmarca')->on('marcas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idestado', 'fk_familia_activos_estados1')->references('idestado')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('familia_activos', function(Blueprint $table)
		{
			$table->dropForeign('fk_familia_activos_tipo_activos1');
			$table->dropForeign('fk_familia_activos_marcas1');
			$table->dropForeign('fk_familia_activos_estados1');
		});
	}

}
