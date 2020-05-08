<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->string('CITY_NAME');
            $table->string('SALARY');
            $table->string('QLI');
            $table->string('LONGITUDE');
            $table->string('LATITUDE');
            $table->string('INFRAESTRUCTURE');
            $table->string('ENVIRONMENT');
            $table->string('POLLUTION');
            $table->string('SAFETY');
            $table->string('HEALTH');
            $table->string('WOMAN');
            $table->string('RENT');
            $table->string('EMPLOYMENT');
            $table->string('DIVERSITY');
            $table->string('TRAFFIC');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salaries');
    }
}
