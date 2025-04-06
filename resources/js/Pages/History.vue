<template>
    <div class="p-6 max-w-3xl mx-auto">
      <h1 class="text-2xl font-bold mb-4">🕓 履歴画面</h1>

      <table class="w-full table-auto border">
        <thead class="bg-gray-200">
          <tr>
            <th class="p-2">作業実施日</th>
            <th class="p-2">開始時間</th>
            <th class="p-2">終了時間</th>
            <th class="p-2">備考</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in histories" :key="item.id">
            <td class="p-2">{{ formatDate(item.completed_at) }}</td>
            <td class="p-2">{{ item.started_at || '13:50:00' }}</td>
            <td class="p-2">{{ formatTime(item.completed_at) }}</td>
            <td class="p-2">{{ item.remarks || '—' }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>

  <script setup>
  import { onMounted, ref } from 'vue'
  import { getTaskHistories } from '@/api'

  // 履歴データ保持用
  const histories = ref([])

  // フォーマット関数
  const formatDate = (datetime) =>
    new Date(datetime).toLocaleDateString('ja-JP', { year: 'numeric', month: '2-digit', day: '2-digit' })

  const formatTime = (datetime) =>
    new Date(datetime).toLocaleTimeString('ja-JP', { hour: '2-digit', minute: '2-digit' })

  // 初回マウント時に履歴取得
  onMounted(async () => {
    try {
      const response = await getTaskHistories()
      histories.value = response.data
    } catch (error) {
      console.error('履歴取得失敗:', error)
    }
  })
  </script>
