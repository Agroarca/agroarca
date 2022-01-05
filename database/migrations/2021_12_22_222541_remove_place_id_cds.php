<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemovePlaceIdCds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fornecedor_centros_distribuicao', function (Blueprint $table) {
            $table->dropColumn('google_place_id');
            $table->dropColumn('google_place_id_updated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fornecedor_centros_distribuicao', function (Blueprint $table) {
            $table->text('google_place_id')->nullable();
            $table->date('google_place_id_updated')->nullable();
        });
    }
}
