<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPersonalOtVmetrologicasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('personal_ot_vmetrologicas', function(Blueprint $table)
		{
			$table->foreign('idot_vmetrologica', 'fk_personal_ot_vmetrologicas_ot_vmetrologicas1')->references('idot_vmetrologica')->on('ot_vmetrologicas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('personal_ot_vmetrologicas', function(Blueprint $table)
		{
			$table->dropForeign('fk_personal_ot_vmetrologicas_ot_vmetrologicas1');
		});
	}

}
