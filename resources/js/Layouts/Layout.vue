<template>
    <div>
      <nav class="bg-gray-100 p-4 mb-6">
        <h1 class="text-2xl font-bold">🧹 掃除当番管理</h1>
        <div class="mt-2">
          <router-link to="/" class="mr-4">🏠 ホーム</router-link>
          <router-link to="/register" class="mr-4">➕ 登録</router-link>
          <router-link to="/history" class="mr-4">📜 履歴</router-link>
          <router-link to="/users/edit">🛠 編集</router-link>
        </div>
      </nav>

      <main>
        <slot />
      </main>
    </div>
  </template>

  <script setup>
  // 特に何も不要
  </script>
