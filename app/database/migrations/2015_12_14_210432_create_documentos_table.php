<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDocumentosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('documentos', function(Blueprint $table)
		{
			$table->integer('iddocumento', true);
			$table->string('nombre', 100);
			$table->string('descripcion', 150)->nullable();
			$table->string('autor', 100);
			$table->string('codigo_archivamiento', 100);
			$table->string('ubicacion', 100);
			$table->string('url', 200)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idtipo_documento')->index('fk_documentos_tipo_documentos1_idx');
			$table->integer('idreporte_instalacion')->nullable()->index('fk_documentos_reporte_instalaciones1_idx');
			$table->integer('idactivo')->nullable()->index('fk_documentos_activos1_idx');
			$table->integer('idcontrato')->nullable()->index('fk_documentos_contratos1_idx');
			$table->integer('idreporte_incumplimiento')->nullable()->index('fk_documentos_reporte_incumplimientos1_idx');
			$table->integer('idsolicitud_compra')->nullable()->index('fk_documentos_solicitud_compras1_idx');
			$table->integer('idestado')->index('fk_documentos_estados1_idx');
			$table->integer('idtipo_acta')->nullable()->index('fk_documentos_tipo_actas1_idx');
			$table->integer('idproveedor')->nullable()->index('fk_documentos_proveedores1_idx');
			$table->dateTime('fecha_acta')->nullable();
			$table->integer('idreporte_retiro')->nullable()->index('fk_documentos_reporte_retiros1_idx');
			$table->integer('idot_vmetrologica')->nullable()->index('fk_documentos_ot_vmetrologicas1_idx');
			$table->string('nombre_archivo', 200)->nullable();
			$table->string('nombre_archivo_encriptado', 200)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('documentos');
	}

}
