<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPagamentoPedidos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->foreignId('forma_pagamento_id')->nullable();
            $table->foreign('forma_pagamento_id')->references('id')->on('formas_pagamento');

            $table->date('data_pagamento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropForeign(['forma_pagamento_id']);
            $table->dropColumn('forma_pagamento_id');
            $table->dropColumn('data_pagamento');
        });
        });
    }
}
