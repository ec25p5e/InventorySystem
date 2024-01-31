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
        Schema::create('user_attributes_def', function (Blueprint $table) {
            $table->id();
            $table->string('def_code');
            $table->string('def_name');
            $table->unsignedBigInteger('user_mod');
            $table->dateTime('attribute_date_start');
            $table->dateTime('attribute_date_end')->nullable();
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
        Schema::dropIfExists('user_attribute_defs');
    }
};