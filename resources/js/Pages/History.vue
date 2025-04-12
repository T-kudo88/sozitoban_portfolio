<template>
    <div class="p-6 max-w-3xl mx-auto">
      <h1 class="text-2xl font-bold mb-4">📜 清掃履歴一覧</h1>

      <div v-if="histories.length === 0" class="text-gray-500 mb-4">
        履歴がまだありません
      </div>

      <table v-else class="w-full border table-auto">
        <thead class="bg-gray-200">
          <tr>
            <th class="p-2 border">作業実施日</th>
            <th class="p-2 border">開始時間</th>
            <th class="p-2 border">終了時間</th>
            <th class="p-2 border">備考</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="history in histories" :key="history.id">
            <td class="p-2 border">{{ formatDate(history.completed_at) }}</td>
            <td class="p-2 border">{{ history.started_at ?? '13:50:00' }}</td>
            <td class="p-2 border">{{ formatTime(history.completed_at) }}</td>
            <td class="p-2 border">{{ history.remarks || '—' }}</td>
          </tr>
        </tbody>
      </table>

      <!-- 戻る -->
      <button
        @click="$router.push('/')"
        class="mt-6 bg-gray-500 text-white px-4 py-2 rounded"
      >
        ホームに戻る
      </button>
    </div>
  </template>

  <script setup>
  import { ref, onMounted } from 'vue'
  import apiClient from '@/api'

  const histories = ref([])

  onMounted(async () => {
    try {
      const res = await apiClient.get('/task-histories')
      histories.value = res.data
    } catch (e) {
      console.error('履歴取得失敗:', e)
    }
  })

  const formatDate = (datetime) =>
    new Date(datetime).toLocaleDateString('ja-JP', {
      year: 'numeric',
      month: '2-digit',
      day: '2-digit'
    })

  const formatTime = (datetime) =>
    new Date(datetime).toLocaleTimeString('ja-JP', {
      hour: '2-digit',
      minute: '2-digit'
    })
  </script>
