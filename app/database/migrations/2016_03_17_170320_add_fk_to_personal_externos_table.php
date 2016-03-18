<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToPersonalExternosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('personal_externos', function(Blueprint $table)
		{
			$table->foreign('id_capacitacion')->references('id')->on('capacitaciones');	
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('personal_externos', function(Blueprint $table)
		{
			$table->dropForeign('personal_externos_id_capacitacion_foreign');
		});
	}

}
