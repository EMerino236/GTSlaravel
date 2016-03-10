<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpedienteTecnicoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('expediente_tecnico', function(Blueprint $table)
		{
			$table->integer('idexpediente_tecnico', true);
			$table->string('codigo_compra', 100);
			$table->string('codigo_archivamiento', 100);
			$table->integer('idtipo_adquisicion_expediente')->index('fk_expediente_tecnico_tipo_adquisicion_expediente1_idx');
			$table->integer('idtipo_compra_expediente')->index('fk_expediente_tecnico_tipo_compra_expediente1_idx');
			$table->string('nombre_equipo',200);
			$table->integer('idarea')->index('fk_expediente_tecnico_areas1_idx');
			$table->integer('idservicio')->index('fk_expediente_tecnico_servicios1_idx')->nullable();
			$table->string('otros_equipos',100)->nullable();
			$table->string('descripcion',255);
			$table->string('url_resolucion', 200)->nullable();
			$table->string('nombre_archivo_resolucion', 200)->nullable();
			$table->string('nombre_archivo_encriptado_resolucion', 200)->nullable();
			$table->string('url_tdr', 200)->nullable();
			$table->string('nombre_archivo_tdr', 200)->nullable();
			$table->string('nombre_archivo_encriptado_tdr', 200)->nullable();
			$table->string('url_bases', 200)->nullable();
			$table->string('nombre_archivo_bases', 200)->nullable();
			$table->string('nombre_archivo_encriptado_bases', 200)->nullable();
			$table->integer('idpresidente')->index('fk_expediente_tecnico_users1_idx')->nullable();
			$table->integer('idmiembro1')->index('fk_expediente_tecnico_users2_idx')->nullable();
			$table->integer('idmiembro2')->index('fk_expediente_tecnico_users3_idx')->nullable();
			$table->integer('idmiembro3')->index('fk_expediente_tecnico_users4_idx')->nullable();
			$table->integer('idproveedor_ganador')->index('fk_expediente_tecnico_proveedores1_idx')->nullable();
			$table->float('precio_ganador',10,2)->nullable();
			$table->string('url_contrato', 200)->nullable();
			$table->string('nombre_archivo_contrato', 200)->nullable();
			$table->string('nombre_archivo_encriptado_contrato', 200)->nullable();
			$table->string('url_documento_adicional', 200)->nullable();
			$table->string('nombre_archivo_documento_adicional', 200)->nullable();
			$table->string('nombre_archivo_encriptado_documento_adicional', 200)->nullable();
			$table->integer('idresponsable')->index('fk_expediente_tecnico_users5_idx');
			$table->integer('estado_evaluacion_ofertas_finalizada');//0:no finalizado, 1:finalizado
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
		Schema::drop('expediente_tecnico');
	}

}
