<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToExpedienteTecnicoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('expediente_tecnico', function(Blueprint $table)
		{
			$table->foreign('idtipo_adquisicion_expediente','fk_expediente_tecnico_tipo_adquisicion_expediente1_idx')->references('idtipo_adquisicion_expediente')->on('tipo_adquisicion_expediente');
			$table->foreign('idtipo_compra_expediente','fk_expediente_tecnico_tipo_compra_expediente1_idx')->references('idtipo_compra_expediente')->on('tipo_compra_expediente');			
			$table->foreign('idpresidente','fk_expediente_tecnico_users1_idx')->references('id')->on('users');
			$table->foreign('idmiembro1','fk_expediente_tecnico_users2_idx')->references('id')->on('users');
			$table->foreign('idmiembro2','fk_expediente_tecnico_users3_idx')->references('id')->on('users');
			$table->foreign('idmiembro3','fk_expediente_tecnico_users4_idx')->references('id')->on('users');
			$table->foreign('idresponsable','fk_expediente_tecnico_users5_idx')->references('id')->on('users');
			$table->foreign('idservicio','fk_expediente_tecnico_servicios1_idx')->references('idservicio')->on('servicios');
			$table->foreign('idarea','fk_expediente_tecnico_areas1_idx')->references('idarea')->on('areas');
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
			$table->dropforeign('fk_expediente_tecnico_tipo_adquisicion_expediente1_idx');
			$table->dropforeign('fk_expediente_tecnico_tipo_compra_expediente1_idx');
			$table->dropforeign('fk_expediente_tecnico_users1_idx');
			$table->dropforeign('fk_expediente_tecnico_users2_idx');
			$table->dropforeign('fk_expediente_tecnico_users3_idx');
			$table->dropforeign('fk_expediente_tecnico_users4_idx');
			$table->dropforeign('fk_expediente_tecnico_users5_idx');
			$table->dropforeign('fk_expediente_tecnico_servicios1_idx');
			$table->dropforeign('fk_expediente_tecnico_areas1_idx');
		});
	}

}
