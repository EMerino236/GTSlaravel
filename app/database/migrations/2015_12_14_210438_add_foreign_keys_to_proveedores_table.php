<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToProveedoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('proveedores', function(Blueprint $table)
		{
			$table->foreign('idestado', 'fk_proveedores_estados1')->references('idestado')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('proveedores', function(Blueprint $table)
		{
			$table->dropForeign('fk_proveedores_estados1');
		});
	}

}
