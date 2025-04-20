<template>
    <div class="min-h-screen flex flex-col items-center py-8 bg-white">

      <!-- タイトル -->
      <h1 class="text-4xl font-bold border border-black px-10 py-2 mb-6">履歴画面</h1>

      <!-- メイン枠 -->
      <div class="border border-black w-[600px] p-6 bg-white">

        <!-- 履歴テーブル -->
        <table class="table-fixed w-full border border-collapse text-center mb-6">
          <thead class="bg-gray-200">
            <tr>
              <th class="border px-4 py-2">作業実施日</th>
              <th class="border px-4 py-2">開始時間</th>
              <th class="border px-4 py-2">終了時間</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(record, index) in histories" :key="index">
    <td class="border px-4 py-2">{{ formatDate(record.started_at) }}</td>
    <td class="border px-4 py-2">{{ formatTime(record.started_at) }}</td>
    <td class="border px-4 py-2">{{ formatTime(record.ended_at) }}</td>
    </tr>
          </tbody>
        </table>

        <!-- 戻るボタン -->
        <div class="flex justify-end">
          <button @click="goBack" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">
            戻る
          </button>
        </div>

      </div>
    </div>
  </template>

  <script setup lang="ts">
  import { ref, onMounted } from 'vue'
  import { useRouter } from 'vue-router'
  import axios from 'axios'

  const router = useRouter()
  const histories = ref([])

  const fetchHistory = async () => {
  try {
    const res = await axios.get('/api/task-histories') // ← 修正ポイント！
    histories.value = res.data.data // ← JSON:API形式（Resource）の場合は .data に格納される
  } catch (e) {
    alert('履歴の取得に失敗しました')
    console.error(e)
  }
}

  // 日付表示（例：2025/04/20）
  const formatDate = (datetime: string): string => {
  if (!datetime) return '-'
  const date = new Date(datetime)
  return isNaN(date.getTime()) ? '-' : date.toLocaleDateString('ja-JP')
}

const formatTime = (datetime: string): string => {
  if (!datetime) return '-'
  const date = new Date(datetime)
  return isNaN(date.getTime()) ? '-' : date.toLocaleTimeString('ja-JP', { hour12: false })
}

  const goBack = () => {
    router.push('/')
  }

  onMounted(() => {
    fetchHistory()
  })
  </script>
