><?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class AddFulltextCidades extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::table('cidades', function (Blueprint $table) {
                $table->fullText('nome');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::table('cidades', function (Blueprint $table) {
                $table->dropFullText(['nome']);
            });
        }
    }
