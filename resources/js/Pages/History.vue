<template>
    <div class="p-10 max-w-4xl mx-auto text-center">
      <h1 class="text-2xl font-bold mb-6">履歴画面</h1>

      <table class="mx-auto border border-collapse w-full">
        <thead class="bg-gray-200">
          <tr>
            <th class="border px-4 py-2">作業日</th>
            <th class="border px-4 py-2">開始時間</th>
            <th class="border px-4 py-2">担当者</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="history in histories" :key="history.id">
            <td class="border px-4 py-2">{{ formatDate(history.completed_at) }}</td>
            <td class="border px-4 py-2">13:50</td>
            <td class="border px-4 py-2">{{ history.user?.name ?? '不明' }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>

  <script setup>
  import { ref, onMounted } from 'vue'
  import { fetchTaskHistories } from '@/api'

  // 履歴データ格納
  const histories = ref([])

  const getHistories = async () => {
    const res = await fetchTaskHistories()
    histories.value = res.data
  }

  const formatDate = (datetime) => {
    if (!datetime) return '-'
    return new Date(datetime).toLocaleDateString()
  }

  onMounted(() => {
    getHistories()
  })
  </script>
