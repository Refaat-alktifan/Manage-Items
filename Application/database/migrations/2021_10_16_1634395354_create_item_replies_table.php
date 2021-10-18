<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemRepliesTable extends Migration
{
    public function up()
    {
        Schema::create('item_replies', function (Blueprint $table) {

		$table->integer('id','10')->unsigned();
		$table->string('tid');
		$table->string('name');
		$table->text('message');
		$table->integer('staff')->default('0');
		$table->timestamp('created_at')->nullable()->default(null);
		$table->timestamp('updated_at')->nullable()->default(null);

        });
    }

    public function down()
    {
        Schema::dropIfExists('item_replies');
    }
}
