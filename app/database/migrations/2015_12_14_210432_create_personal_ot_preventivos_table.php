<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePersonalOtPreventivosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('personal_ot_preventivos', function(Blueprint $table)
		{
			$table->integer('idpersonal_ot_preventivo', true);
			$table->string('nombre', 200)->nullable();
			$table->float('horas_hombre', 10, 0);
			$table->float('costo', 10, 0);
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idot_preventivo')->index('fk_personal_ot_preventivos_ot_preventivos1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('personal_ot_preventivos');
	}

}
