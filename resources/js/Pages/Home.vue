<template>
    <div class="p-10 max-w-5xl mx-auto text-center">
      <h1 class="text-3xl font-bold mb-6">ホーム画面</h1>

      <!-- 🧼 表：タスク一覧 -->
      <table class="mx-auto border border-collapse w-full max-w-4xl mb-6">
        <thead class="bg-gray-200">
          <tr>
            <th class="border px-4 py-2">担当者</th>
            <th class="border px-4 py-2">担当席</th>
            <th class="border px-4 py-2">掃除方法</th>
            <th class="border px-4 py-2">使う道具</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="task in tasks" :key="task.id">
            <td class="border px-4 py-2">{{ task.user?.name ?? '不明' }}</td>
            <td class="border px-4 py-2">{{ task.seat ?? '-' }}</td>
            <td class="border px-4 py-2">{{ task.method ?? '-' }}</td>
            <td class="border px-4 py-2">{{ task.tool ?? '-' }}</td>
          </tr>
        </tbody>
      </table>

      <!-- 🔵 シャッフル -->
      <div class="mb-4">
        <button @click="shuffleTasks"
          class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
          シャッフル
        </button>
      </div>

      <!-- ⏲ タイマー表示 -->
      <div class="text-6xl font-mono border-2 border-black rounded w-fit mx-auto px-6 py-2 my-4">
        {{ formatTime }}
      </div>

      <!-- 🟠 スタート -->
      <div class="mb-4">
        <button @click="startTask"
          :disabled="isRunning"
          class="bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600 disabled:opacity-50">
          スタート
        </button>
      </div>
    </div>
  </template>

  <script setup lang="ts">
  import { ref, onMounted, computed } from 'vue'
  import { fetchTasks, shuffleTasks as callShuffleAPI, createTaskHistory } from '@/api'

  // 🧹 タスク一覧
  const tasks = ref([])

  const getTasks = async () => {
    const res = await fetchTasks()
    tasks.value = res.data
  }

  // ⏱ タイマー関連
  const timer = ref(600) // 10分 = 600秒
  const isRunning = ref(false)
  let intervalId: ReturnType<typeof setInterval> | null = null

  const formatTime = computed(() => {
    const min = String(Math.floor(timer.value / 60)).padStart(2, '0')
    const sec = String(timer.value % 60).padStart(2, '0')
    return `${min}:${sec}`
  })

  const startTimer = () => {
    if (isRunning.value) return
    isRunning.value = true
    timer.value = 600 // 毎回リセット

    intervalId = setInterval(() => {
      if (timer.value > 0) {
        timer.value--
      } else {
        clearInterval(intervalId!)
        isRunning.value = false
        alert('タイマー終了！')
      }
    }, 1000)
  }

  // 📋 スタート処理＋履歴作成
  const startTask = async () => {
    const task = tasks.value[Math.floor(Math.random() * tasks.value.length)]
    if (!task || !task.user?.id) {
      alert('対象のタスクが見つかりませんでした')
      return
    }

    try {
      await createTaskHistory({
        user_id: task.user.id,
        task_id: task.id,
      })
      startTimer()
      alert('履歴に記録しました！タイマー開始！')
    } catch (e) {
      console.error(e)
      alert('記録に失敗しました')
    }
  }

  // 🔄 シャッフル処理
  const shuffleTasks = async () => {
    try {
      await callShuffleAPI()
      await getTasks()
    } catch (error) {
      console.error('シャッフル失敗:', error)
    }
  }

  onMounted(() => {
    getTasks()
  })
  </script>
