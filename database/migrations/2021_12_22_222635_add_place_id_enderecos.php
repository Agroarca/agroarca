<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlaceIdEnderecos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('usuario_enderecos', function (Blueprint $table) {
            $table->text('google_place_id')->nullable();
            $table->date('google_pace_id_updated')->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('usuario_enderecos', function (Blueprint $table) {
            $table->dropColumn('google_place_id');
            $table->dropColumn('google_pace_id_updated');
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
        });
    }
}
