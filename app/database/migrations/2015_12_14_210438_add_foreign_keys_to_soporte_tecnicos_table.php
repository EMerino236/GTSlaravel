<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSoporteTecnicosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('soporte_tecnicos', function(Blueprint $table)
		{
			$table->foreign('idtipo_documento', 'fk_soporte_tecnicos_tipo_doc_identidades1')->references('idtipo_documento')->on('tipo_doc_identidades')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idproveedor', 'fk_soporte_tecnicos_proveedores1')->references('idproveedor')->on('proveedores')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('soporte_tecnicos', function(Blueprint $table)
		{
			$table->dropForeign('fk_soporte_tecnicos_tipo_doc_identidades1');
			$table->dropForeign('fk_soporte_tecnicos_proveedores1');
		});
	}

}
