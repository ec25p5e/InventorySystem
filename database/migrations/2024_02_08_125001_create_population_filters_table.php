<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('populations', function (Blueprint $table) {
            $table->id();
            $table->string('population_code');
            $table->string('population_name')->nullable();
            $table->unsignedBigInteger('unity_id');
            $table->unsignedBigInteger('user_id_ref');
            $table->unsignedBigInteger('user_mod');
            $table->timestamps();
        });

        Schema::create('population_filters', function (Blueprint $table) {
            $table->id();
            $table->string('code_ref');
            $table->string('filter_operator');
            $table->string('filter_value');
            $table->unsignedBigInteger('population_id');
            $table->unsignedBigInteger('user_mod');
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
        Schema::dropIfExists('population_filters');
    }
};
