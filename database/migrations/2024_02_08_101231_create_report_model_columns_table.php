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
        Schema::create('report_model_columns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('command_id');
            $table->unsignedBigInteger('report_id');
            $table->string('column_name');
            $table->string('column_signature');
            $table->timestamps();
        });

        Schema::create('report_models', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unity_id');
            $table->unsignedBigInteger('user_id');
            $table->string('report_name');
            $table->string('report_description');
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
        Schema::dropIfExists('report_model_columns');
    }
};
