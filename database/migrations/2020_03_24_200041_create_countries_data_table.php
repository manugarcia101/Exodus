<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries_data', function (Blueprint $table) {
            $table->string('COUNTRY');
            $table->string('SALARY');
            $table->string('CPI');
            $table->string('PURCHASING_POWER');
            $table->string('POLLUTION');
            $table->string('SAFETY');
            $table->string('TRAFFIC');
            $table->string('HEALTH');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries_data');
    }
}
