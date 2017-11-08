<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldAnuncioValorPromocional extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('anuncios', function (Blueprint $table) {
			$table->double('valor_promocional')->nullable();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		if (Schema::hasColumn('anuncios', 'valor_promocional')) {
			Schema::table('anuncios', function (Blueprint $table) {
				$table->dropColumn('valor_promocional');
			});
		}
    }
}
