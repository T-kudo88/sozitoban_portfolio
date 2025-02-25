<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,  // 修正：Seederを正しく登録
            TasksTableSeeder::class,  // 他のSeederも必要なら追加
        ]);
    }
}
