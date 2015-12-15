<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSoporteTecnicosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('soporte_tecnicos', function(Blueprint $table)
		{
			$table->integer('idsoporte_tecnico', true);
			$table->string('numero_doc_identidad', 20);
			$table->string('nombres', 100);
			$table->string('apellido_pat', 200);
			$table->string('apellido_mat', 200);
			$table->string('telefono', 45);
			$table->string('email', 45);
			$table->string('especialidad', 45);
			$table->integer('idtipo_documento')->index('fk_soporte_tecnicos_tipo_doc_identidades1_idx');
			$table->integer('idproveedor')->index('fk_soporte_tecnicos_proveedores1_idx');
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('soporte_tecnicos');
	}

}
