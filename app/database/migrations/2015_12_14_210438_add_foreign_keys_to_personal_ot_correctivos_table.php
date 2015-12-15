<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPersonalOtCorrectivosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('personal_ot_correctivos', function(Blueprint $table)
		{
			$table->foreign('idot_correctivo', 'fk_personal_ot_correctivos_ot_correctivos1')->references('idot_correctivo')->on('ot_correctivos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('personal_ot_correctivos', function(Blueprint $table)
		{
			$table->dropForeign('fk_personal_ot_correctivos_ot_correctivos1');
		});
	}

}
