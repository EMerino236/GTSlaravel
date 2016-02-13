<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventoxpersonasImplicadasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('eventoxpersonas_implicadas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('idevento')->unsigned();
			$table->integer('idpersonas_implicada')->unsigned();
			$table->integer('cantidad');
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
		Schema::drop('eventoxpersonas_implicadas');
	}

}
