<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProveedoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('proveedores', function(Blueprint $table)
		{
			$table->integer('idproveedor', true);
			$table->string('ruc', 11);
			$table->string('razon_social', 100);
			$table->string('nombre_contacto', 200);
			$table->string('telefono', 45);
			$table->string('email', 45);
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idestado')->index('fk_proveedores_estados1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('proveedores');
	}

}
