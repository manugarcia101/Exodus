<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities_data', function (Blueprint $table) {
            $table->string('CITY_NAME');
            $table->string('SALARY');
            $table->string('INFRAESTRUCTURE');
            $table->string('ENVIRONMENT');
            $table->string('POLLUTION');
            $table->string('SAFETY');
            $table->string('QLI');
            $table->string('HEALTH');
            $table->string('WOMAN');
            $table->string('RENT');
            $table->string('LONGITUDE');
            $table->string('EMPLOYMENT');
            $table->string('DIVERSITY');
            $table->string('LATITUDE');
            $table->string('TRAFFIC');
            $table->string('PURCHASING');
            $table->string('CPI');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities_data');
    }
}
