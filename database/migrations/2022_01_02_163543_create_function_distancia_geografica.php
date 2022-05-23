<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateFunctionDistanciaGeografica extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // executar como root: SET GLOBAL log_bin_trust_function_creators = 1;
        DB::unprepared('drop function if exists distanciaGeografica;');
        DB::unprepared('
            create function distanciaGeografica(lat1 double, long1 double, lat2 double, long2 double)
            returns double deterministic
            begin
                declare r_lat1 double;
                declare r_lat2 double;
                declare r_lons double;
                declare distance double;

                set r_lat1 = radians(90 - lat1);
                set r_lat2 = radians(90 - lat2);
                SET r_lons = RADIANS(long1-long2);

                set distance = 6371 * ACOS(
                    COS(r_lat1) * COS(r_lat2) +
                    SIN(r_lat1) * SIN(r_lat2) * COS(r_lons)
                );

                return distance;
            end
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('drop function if exists distanciaGeografica;');
    }
}
