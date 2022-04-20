<?php

use App\Models\Administracao\Dominio;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDominios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dominios', function (Blueprint $table) {
            $table->id();
            $table->string('dominio');
            $table->string('nome');
            $table->timestamps();
        });

        $dominio = config('app.url');
        $dominio = str_replace('http://', '', $dominio);
        $dominio = str_replace('https://', '', $dominio);
        Dominio::create([
            'dominio' => $dominio,
            'nome' => config('app.name')
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dominios');
    }
}
