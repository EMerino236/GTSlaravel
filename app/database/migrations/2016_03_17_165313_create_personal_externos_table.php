<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalExternosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('personal_externos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre',100);
			$table->string('descripcion',200);
			$table->string('rol',100);
			$table->string('institucion',100);
			$table->integer('id_capacitacion')->unsigned();
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
		Schema::drop('personal_externos');
	}

}
