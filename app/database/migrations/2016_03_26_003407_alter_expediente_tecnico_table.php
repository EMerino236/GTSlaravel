<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterExpedienteTecnicoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('expediente_tecnico', function(Blueprint $table)
		{			
			$table->dropIndex('fk_expediente_tecnico_proveedores1_idx');
			$table->dropColumn('precio_ganador');
			$table->dropColumn('idproveedor_ganador');
			$table->integer('idoferta_ganador')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('expediente_tecnico', function(Blueprint $table)
		{
			//
		});
	}

}
