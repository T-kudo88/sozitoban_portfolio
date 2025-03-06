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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('position', 30)->default('未設定');
            $table->string('email', 100)->unique();
            $table->string('slack_id', 50)->unique()->nullable();
            $table->boolean('notify_email')->default(true);
            $table->boolean('notify_slack')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->string('password'); // 🔹 パスワードカラムを追加
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
