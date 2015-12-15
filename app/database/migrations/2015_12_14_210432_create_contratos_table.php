<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContratosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contratos', function(Blueprint $table)
		{
			$table->integer('idcontrato', true);
			$table->dateTime('fecha_contrato')->nullable();
			$table->integer('idorden_compra')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idproveedor')->index('fk_contratos_proveedores1_idx');
			$table->integer('id_responsable')->index('fk_contratos_users1_idx');
			$table->integer('idestado')->index('fk_contratos_estados1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contratos');
	}

}
