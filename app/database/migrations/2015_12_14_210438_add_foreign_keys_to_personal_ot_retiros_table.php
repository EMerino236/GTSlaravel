<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPersonalOtRetirosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('personal_ot_retiros', function(Blueprint $table)
		{
			$table->foreign('idot_retiro', 'fk_personal_ot_retiros_ot_retiros1')->references('idot_retiro')->on('ot_retiros')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('personal_ot_retiros', function(Blueprint $table)
		{
			$table->dropForeign('fk_personal_ot_retiros_ot_retiros1');
		});
	}

}
