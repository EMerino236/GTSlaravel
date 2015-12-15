<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToRepuestosOtCorrectivoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('repuestos_ot_correctivo', function(Blueprint $table)
		{
			$table->foreign('idot_correctivo', 'fk_repuestos_ot_correctivo_ot_correctivos1')->references('idot_correctivo')->on('ot_correctivos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('repuestos_ot_correctivo', function(Blueprint $table)
		{
			$table->dropForeign('fk_repuestos_ot_correctivo_ot_correctivos1');
		});
	}

}
