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
        /**
         * 'attribute_code',
         * 'attribute_name',
         * 'attribute_value',
         * 'attribute_hidden',
         * 'attribute_unique',
         * 'attribute_log',
         * 'attribute_date_start',
         * 'attribute_date_end',
         * 'user_id',
         * 'user_mod'
         */


        Schema::create('user_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('attribute_code');
            $table->string('attribute_name')->nullable();
            $table->string('attribute_value');
            $table->boolean('attribute_hidden');
            $table->boolean('attribute_unique');
            $table->string('attribute_log');
            $table->string('attribute_log_detail');
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('user_attributes');
    }
};
