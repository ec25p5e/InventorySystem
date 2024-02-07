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
        Schema::create('vars', function (Blueprint $table) {
            $table->id();
            $table->string('command_code');
            $table->string('command_name');
            $table->string('command_description');
            $table->string('command_signature');
            $table->string('command_options');
            $table->longText('command_body');
            $table->unsignedBigInteger('command_unity_ref')->nullable();
            $table->unsignedBigInteger('command_user_ref')->nullable();
            $table->dateTime('command_date_start');
            $table->dateTime('command_date_end')->nullable();
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
        Schema::dropIfExists('vars');
    }
};
