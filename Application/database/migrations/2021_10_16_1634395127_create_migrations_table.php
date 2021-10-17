<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMigrationsTable extends Migration
{
    public function up()
    {
        Schema::create('migrations', function (Blueprint $table) {

            $table->integer('id', '10')->unsigned();
            $table->string('migration');
            $table->integer('batch');

        });
    }

    public function down()
    {
        Schema::dropIfExists('migrations');
    }
}
