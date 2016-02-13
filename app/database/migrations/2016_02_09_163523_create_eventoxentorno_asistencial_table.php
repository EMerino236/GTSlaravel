<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventoxentornoAsistencialTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('eventoxentorno_asistencial', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('identorno')->unsigned();
			$table->integer('idevento')->unsigned();
			$table->string('comentario',200);
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
		Schema::drop('eventoxentorno_asistencial');
	}

}
