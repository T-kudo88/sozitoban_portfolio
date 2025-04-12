<script setup lang="ts">
import TaskList from './components/TaskList.vue'
import TaskForm from './components/TaskForm.vue'
import ShuffleButton from './components/ShuffleButton.vue'

const token = import.meta.env.VITE_API_TOKEN
console.log('✅ トークン確認:', token)
</script>

<template>
  <div>
    <h1>🧹 Cleaning App</h1>

    <!-- タスク作成フォーム -->
    <TaskForm />

    <!-- シャッフルボタン -->
    <ShuffleButton />

    <!-- タスク一覧 -->
    <TaskList />
  </div>
</template>
