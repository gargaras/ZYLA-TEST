<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currents', function (Blueprint $table) {
            $table->id();
            $table->string("observation_time");
            $table->bigInteger("temperature");
            $table->bigInteger("weather_code");
            $table->string("weather_icons");
            $table->string("weather_descriptions");
            $table->bigInteger("wind_speed");
            $table->bigInteger("wind_degree");
            $table->string("wind_dir");
            $table->bigInteger("pressure");
            $table->bigInteger("precip");
            $table->bigInteger("humidity");
            $table->bigInteger("cloudcover");
            $table->bigInteger("feelslike");
            $table->bigInteger("uv_index");
            $table->bigInteger("visibility");
            $table->string("is_day");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currents');
    }
}
