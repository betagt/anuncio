<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnuncioExcluirFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anuncio_excluir_forms', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('anuncio_id')->unsigned();
            $table->foreign('anuncio_id')->references('id')->on('anuncios');
            $table->boolean('satisfacao');
            $table->text('satisfacao_text')->nullable();
            $table->enum('vendeu_qimob',[
                'sim',
                'nao_outra_forma',
                'nao_vendi',
            ]);
            $table->double('vendeu_qimob_valor')->nullable();
            $table->string('vendeu_qimob_outro')->nullable();
            $table->boolean('depoimento')->default(false);
            $table->string('depoimento_text')->nullable();
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
        Schema::drop('anuncio_excluir_forms');
    }
}
