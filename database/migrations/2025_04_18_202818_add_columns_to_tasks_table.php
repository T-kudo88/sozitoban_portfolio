<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tasks', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->string('seat')->nullable()->after('area');
            $table->string('method')->nullable()->after('seat');
            $table->string('tool')->nullable()->after('method');
        });
    }

    public function down()
    {
        Schema::table('tasks', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->dropColumn(['seat', 'method', 'tool']);
        });
    }
};
