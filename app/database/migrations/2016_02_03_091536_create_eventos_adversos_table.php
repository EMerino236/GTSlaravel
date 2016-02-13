<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventosAdversosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('eventos_adversos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('codigo_abreviatura',2);
			$table->string('codigo_correlativo',4);
			$table->string('nombre_paciente',200);
			$table->integer('idtipo_documento');
			$table->integer('numero_documento');
			$table->integer('edad');
			$table->string('sexo',1);
			$table->date('fecha_reporte');
			$table->date('fecha_incidente');
			$table->integer('idfrecuencia')->unsigned();
			$table->string('tipo_danho',100);
			$table->integer('idgrado_danho')->unsigned();
			$table->string('impacto_socioeconomico',500);
			$table->integer('idetapa_servicio')->unsigned()->nullable();
			$table->string('disciplina',100);
			$table->integer('idfactor')->unsigned();
			$table->integer('idproceso')->unsigned();
			$table->string('danho_bienes',100);
			$table->string('procedimiento',500);
			$table->string('diagnostico',500);
			$table->string('causa',500);
			$table->string('medidas',500);
			$table->integer('idactivo');
			$table->string('informacion',500);
			$table->string('nombre_reportante',100);
			$table->string('profesion',100);
			$table->string('direccion',100);
			$table->string('email',100);
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
		Schema::drop('eventos_adversos');
	}

}
