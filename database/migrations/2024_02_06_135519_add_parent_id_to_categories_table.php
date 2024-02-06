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
        Schema::table('unities', function (Blueprint $table) {
            $table->foreign('unity_ref_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unities', function (Blueprint $table) {
            $table->dropForeign(['unity_ref_id']);
            $table->dropColumn('unity_ref_id');
        });
    }
};
