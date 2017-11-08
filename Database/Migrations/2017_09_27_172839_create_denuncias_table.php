<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDenunciasTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('denuncias', function(Blueprint $table) {
            $table->increments('id');
            $table->enum('problema', [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15]);
            $table->string('descricao');
            $table->string('nome');
            $table->string('email');
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('denuncias');
	}

}
