<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->string('name',25);
		$table->string('email',155)->unique('users_email_unique');
		$table->string('department',225);
		$table->tinyInteger('is_admin')->default('0');
		$table->string('password');
		$table->string('remember_token',100)->nullable()->default(null);
		$table->timestamp('created_at')->nullable()->default(null);
		$table->timestamp('updated_at')->nullable()->default(null);

        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
