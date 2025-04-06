<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">🧹 掃除当番一覧</h1>

      <table class="min-w-full border">
        <thead>
          <tr class="bg-gray-100 text-left">
            <th class="border px-4 py-2">ID</th>
            <th class="border px-4 py-2">担当者</th>
            <th class="border px-4 py-2">掃除エリア</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="task in tasks" :key="task.id">
            <td class="border px-4 py-2">{{ task.id }}</td>
            <td class="border px-4 py-2">{{ task.user?.name ?? '不明' }}</td>
            <td class="border px-4 py-2">{{ task.area }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>

  <script setup>
  import { ref, onMounted } from 'vue'
  import axios from 'axios'

  const tasks = ref([])

  onMounted(async () => {
    try {
      const res = await axios.get('/api/tasks')
      tasks.value = res.data
    } catch (err) {
      console.error('タスク取得エラー:', err)
    }
  })
  </script>

  <style scoped>
  table {
    border-collapse: collapse;
    width: 100%;
  }
  </style>
