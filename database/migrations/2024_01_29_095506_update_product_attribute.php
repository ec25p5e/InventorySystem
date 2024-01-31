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
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('attribute_code');
            $table->text('attribute_name')->nullable();
            $table->string('attribute_value');
            $table->boolean('attribute_hidden');
            $table->boolean('attribute_unique');
            $table->dateTime('attribute_date_start');
            $table->dateTime('attribute_date_end')->nullable();
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
        //
    }
};
