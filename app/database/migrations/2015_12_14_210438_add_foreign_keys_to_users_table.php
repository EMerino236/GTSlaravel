<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->foreign('idrol', 'fk_users_roles')->references('idrol')->on('roles')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idarea', 'fk_users_areas1')->references('idarea')->on('areas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idtipo_documento', 'fk_users_tipo_doc_identidades1')->references('idtipo_documento')->on('tipo_doc_identidades')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropForeign('fk_users_roles');
			$table->dropForeign('fk_users_areas1');
			$table->dropForeign('fk_users_tipo_doc_identidades1');
		});
	}

}
