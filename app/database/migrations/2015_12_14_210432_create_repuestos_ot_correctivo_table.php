<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRepuestosOtCorrectivoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('repuestos_ot_correctivo', function(Blueprint $table)
		{
			$table->integer('idrepuestos_ot_correctivo', true);
			$table->string('nombre', 200)->nullable();
			$table->string('codigo', 45)->nullable();
			$table->integer('cantidad')->nullable();
			$table->float('costo', 10, 0)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idot_correctivo')->index('fk_repuestos_ot_correctivo_ot_correctivos1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('repuestos_ot_correctivo');
	}

}
