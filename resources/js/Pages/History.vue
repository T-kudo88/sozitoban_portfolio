<template>
    <div class="p-6 max-w-5xl mx-auto">
      <h1 class="text-2xl font-bold mb-6">履歴一覧</h1>

      <table class="w-full border border-collapse mb-6">
        <thead class="bg-gray-200">
          <tr>
            <th class="border px-4 py-2">担当者</th>
            <th class="border px-4 py-2">掃除場所</th>
            <th class="border px-4 py-2">掃除方法</th>
            <th class="border px-4 py-2">使う道具</th>
            <th class="border px-4 py-2">実施日時</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="history in histories" :key="history.id">
            <td class="border px-4 py-2">{{ history.user?.name ?? '不明' }}</td>
            <td class="border px-4 py-2">{{ history.task?.area ?? '-' }}</td>
            <td class="border px-4 py-2">{{ history.task?.method ?? '-' }}</td>
            <td class="border px-4 py-2">{{ history.task?.tool ?? '-' }}</td>
            <td class="border px-4 py-2">{{ formatDate(history.completed_at) }}</td>
          </tr>
        </tbody>
      </table>

      <button @click="router.push('/')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
        戻る
      </button>
    </div>
  </template>

  <script setup lang="ts">
  import { ref, onMounted } from 'vue'
  import { useRouter } from 'vue-router'
  import axios from 'axios'

  const router = useRouter()
  const histories = ref([])

  const getHistories = async () => {
    const res = await axios.get('/api/task-histories')
    histories.value = res.data
  }

  const formatDate = (dateStr: string) => {
    const date = new Date(dateStr)
    return date.toLocaleString('ja-JP', { timeZone: 'Asia/Tokyo' })
  }

  onMounted(getHistories)
  </script>
