<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGruposTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('grupos', function(Blueprint $table)
		{
			$table->integer('idgrupo', true);
			$table->string('nombre', 100);
			$table->string('descripcion', 200)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('id_responsable')->index('fk_grupos_users1_idx');
			$table->integer('idestado')->index('fk_grupos_estados1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('grupos');
	}

}
