<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToContratosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contratos', function(Blueprint $table)
		{
			$table->foreign('idproveedor', 'fk_contratos_proveedores1')->references('idproveedor')->on('proveedores')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_responsable', 'fk_contratos_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idestado', 'fk_contratos_estados1')->references('idestado')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('contratos', function(Blueprint $table)
		{
			$table->dropForeign('fk_contratos_proveedores1');
			$table->dropForeign('fk_contratos_users1');
			$table->dropForeign('fk_contratos_estados1');
		});
	}

}
