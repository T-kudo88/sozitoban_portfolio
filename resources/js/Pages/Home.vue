<template>
    <div class="min-h-screen flex flex-col items-center py-8 bg-white relative">
      <!-- タイトル -->
      <h1 class="text-4xl font-bold border border-black px-10 py-2 mb-6">ホーム画面</h1>

      <!-- メイン枠 -->
      <div class="border border-black w-[900px] p-6 bg-white">

        <!-- 登録・編集ボタン -->
        <div class="flex justify-end mb-4 space-x-4">
          <router-link to="/register">
            <button class="bg-green-600 text-white px-4 py-2 rounded">登録</button>
          </router-link>
          <router-link to="/edit">
            <button class="bg-red-600 text-white px-4 py-2 rounded">編集</button>
          </router-link>
        </div>

        <!-- 表 -->
        <table class="table-fixed w-full border border-collapse text-center mb-2">
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
    <td class="border px-4 py-2">{{ task.user?.name || '-' }}</td>
    <td class="border px-4 py-2">{{ task.seat || '-' }}</td>
    <td class="border px-4 py-2">{{ task.method || '-' }}</td>
    <td class="border px-4 py-2">{{ task.tool || '-' }}</td>
  </tr>
</tbody>
        </table>

        <!-- ✅ 表の右下：シャッフル・履歴ボタン -->
        <div class="flex justify-end space-x-4 mb-6">
          <button @click="shuffleTasks" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">シャッフル</button>
          <router-link to="/history">
            <button class="bg-pink-500 text-white px-6 py-2 rounded hover:bg-pink-600">履歴</button>
          </router-link>
        </div>

        <!-- タイマー -->
        <div class="text-6xl font-mono border-2 border-black rounded px-12 py-6 mx-auto mb-6 w-fit">
          {{ formatTime }}
        </div>

        <!-- スタートボタン -->
        <div class="flex justify-center mb-4">
          <button @click="startTask" :disabled="isRunning"
            class="bg-orange-500 text-white px-10 py-3 rounded text-lg hover:bg-orange-600 disabled:opacity-50">
            スタート
          </button>
        </div>
      </div>
    </div>
  </template>

  <script setup lang="ts">
  import { ref, onMounted, computed } from 'vue'
  import { fetchTasks, shuffleTasks as callShuffleAPI } from '@/api/tasks'
　import { createTaskHistory } from '@/api/history'

  const tasks = ref([])

  const getTasks = async () => {
    const res = await fetchTasks()
    tasks.value = res.data
  }

  const timer = ref(600)
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
    timer.value = 600

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
