<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_remove_area_from_tasks_table.php
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('area');
        });
    }

    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('area')->nullable(); // もとに戻す
        });
    }
};
