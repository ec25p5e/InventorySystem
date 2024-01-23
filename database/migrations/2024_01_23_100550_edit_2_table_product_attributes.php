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
         * 'attribute_date_start',
         * 'attribute_date_end'
         */

        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('attribute_code')->unique();
            $table->text('attribute_name')->nullable();
            $table->string('attribute_value');
            $table->boolean('attribute_hidden');
            $table->dateTime('attribute_date_start');
            $table->dateTime('attribute_date_end');
            $table->integer('product_ref_id');
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
        Schema::dropIfExists('product_attributes');
    }
};
