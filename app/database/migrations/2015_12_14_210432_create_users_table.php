<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('username', 100);
			$table->string('password', 64);
			$table->string('email', 45);
			$table->string('remember_token', 100);
			$table->string('nombre', 100);
			$table->string('apellido_pat', 200);
			$table->string('apellido_mat', 200);
			$table->dateTime('fecha_nacimiento')->nullable();
			$table->string('genero', 1);
			$table->string('numero_doc_identidad', 20);
			$table->string('telefono', 20)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('idrol')->index('fk_users_roles_idx');
			$table->integer('idarea')->index('fk_users_areas1_idx');
			$table->integer('idtipo_documento')->index('fk_users_tipo_doc_identidades1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
