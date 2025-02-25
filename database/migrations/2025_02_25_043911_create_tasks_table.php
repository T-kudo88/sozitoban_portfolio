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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // 自動インクリメントのID
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // 掃除担当者（usersテーブルの外部キー）
            $table->string('area'); // 担当エリア
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP')); // 作成日時
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')); // 更新日時
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
