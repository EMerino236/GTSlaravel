<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDocumentosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('documentos', function(Blueprint $table)
		{
			$table->foreign('idtipo_documento', 'fk_documentos_tipo_documentos1')->references('idtipo_documento')->on('tipo_documentos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idreporte_instalacion', 'fk_documentos_reporte_instalaciones1')->references('idreporte_instalacion')->on('reporte_instalaciones')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idactivo', 'fk_documentos_activos1')->references('idactivo')->on('activos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idcontrato', 'fk_documentos_contratos1')->references('idcontrato')->on('contratos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idreporte_incumplimiento', 'fk_documentos_reporte_incumplimientos1')->references('idreporte_incumplimiento')->on('reporte_incumplimientos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idsolicitud_compra', 'fk_documentos_solicitud_compras1')->references('idsolicitud_compra')->on('solicitud_compras')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idestado', 'fk_documentos_estados1')->references('idestado')->on('estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idtipo_acta', 'fk_documentos_tipo_actas1')->references('idtipo_acta')->on('tipo_actas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idproveedor', 'fk_documentos_proveedores1')->references('idproveedor')->on('proveedores')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idreporte_retiro', 'fk_documentos_reporte_retiros1')->references('idreporte_retiro')->on('reporte_retiros')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idot_vmetrologica', 'fk_documentos_ot_vmetrologicas1')->references('idot_vmetrologica')->on('ot_vmetrologicas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('documentos', function(Blueprint $table)
		{
			$table->dropForeign('fk_documentos_tipo_documentos1');
			$table->dropForeign('fk_documentos_reporte_instalaciones1');
			$table->dropForeign('fk_documentos_activos1');
			$table->dropForeign('fk_documentos_contratos1');
			$table->dropForeign('fk_documentos_reporte_incumplimientos1');
			$table->dropForeign('fk_documentos_solicitud_compras1');
			$table->dropForeign('fk_documentos_estados1');
			$table->dropForeign('fk_documentos_tipo_actas1');
			$table->dropForeign('fk_documentos_proveedores1');
			$table->dropForeign('fk_documentos_reporte_retiros1');
			$table->dropForeign('fk_documentos_ot_vmetrologicas1');
		});
	}

}
