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
import api from '@/api'

const timer = ref(600) // 10分 = 600秒
const isRunning = ref(false)
let interval = null

const startTimer = () => {
  if (isRunning.value) return
  isRunning.value = true
  interval = setInterval(() => {
    if (timer.value > 0) {
      timer.value--
    } else {
      clearInterval(interval)
      isRunning.value = false
      alert("🕓 掃除完了です！履歴に記録されます。")
      submitHistory() // タイマー終了後に履歴登録
    }
  }, 1000)
}

const formatTime = () => {
  const min = String(Math.floor(timer.value / 60)).padStart(2, '0')
  const sec = String(timer.value % 60).padStart(2, '0')
  return `${min}:${sec}`
}

// 履歴登録（簡易版）
const submitHistory = async () => {
  try {
    await api.client.post('/task-histories', {
      user_id: 1, // 仮のユーザーID（本番ではログインユーザーのIDを渡す）
      task_id: 1, // 仮のタスクID（実装済みのシャッフル結果から渡す想定）
      remarks: '自動登録'
    })
  } catch (e) {
    console.error('履歴登録エラー', e)
  }
}
</script>
