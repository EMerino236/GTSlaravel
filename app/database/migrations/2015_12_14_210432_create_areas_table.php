<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAreasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('areas', function(Blueprint $table)
		{
			$table->integer('idarea', true);
			$table->string('nombre', 100);
			$table->string('descripcion', 200)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idtipo_area')->index('fk_areas_tipo_areas1_idx');
			$table->integer('idestado')->index('fk_areas_estados1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('areas');
	}

}
