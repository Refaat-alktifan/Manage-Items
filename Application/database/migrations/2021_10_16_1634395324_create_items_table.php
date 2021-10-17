<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {

		$table->integer('id','10')->unsigned();
		$table->string('tid');
		$table->string('priority');
		$table->string('department');
		$table->string('subject');
		$table->string('name');
		$table->string('email');
		$table->text('message');
		$table->tinyInteger('status');
		$table->timestamp('created_at')->nullable()->default(null);
		$table->timestamp('updated_at')->nullable()->default(null);

        });
    }

    public function down()
    {
        Schema::dropIfExists('items');
    }
}
