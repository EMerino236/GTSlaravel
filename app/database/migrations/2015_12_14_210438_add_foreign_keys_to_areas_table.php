<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAreasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('areas', function(Blueprint $table)
		{
			$table->foreign('idtipo_area', 'fk_areas_tipo_areas1')->references('idtipo_area')->on('tipo_areas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idestado', 'fk_areas_estados1')->references('idestado')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('areas', function(Blueprint $table)
		{
			$table->dropForeign('fk_areas_tipo_areas1');
			$table->dropForeign('fk_areas_estados1');
		});
	}

}
