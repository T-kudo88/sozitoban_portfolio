<template>
    <div class="p-10 max-w-5xl mx-auto text-center">
      <h1 class="text-3xl font-bold mb-6">ホーム画面</h1>

      <!-- 上部リンク -->
      <div class="flex justify-end gap-4 mb-6">
        <router-link to="/register" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">登録</router-link>
        <router-link to="/users/edit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">編集</router-link>
      </div>

      <!-- 表 -->
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
            <td class="border px-4 py-2 text-center">{{ task.user?.name ?? '不明' }}</td>
            <td class="border px-4 py-2 text-center">{{ task.seat ?? '-' }}</td>
            <td class="border px-4 py-2 text-center">{{ task.method ?? '-' }}</td>
            <td class="border px-4 py-2 text-center">{{ task.tool ?? '-' }}</td>
          </tr>
        </tbody>
      </table>

      <!-- 選択とボタン -->
      <div class="mb-4">
        <select v-model="selectedUserId" class="border p-2 rounded">
          <option disabled value="">担当者を選んでください</option>
          <option v-for="user in users" :key="user.id" :value="user.id">
            {{ user.name }}
          </option>
        </select>
      </div>

      <div class="flex justify-center gap-4 mb-6">
        <button @click="shuffleTasks" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">シャッフル</button>
        <router-link to="/history" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">履歴</router-link>
      </div>

      <!-- タイマー -->
      <div class="text-8xl font-mono my-6 border-2 border-black rounded w-fit mx-auto px-6 py-2">
        {{ formatTime() }}
      </div>

      <!-- スタート -->
      <button
        @click="startTimer"
        :disabled="isRunning || !selectedUserId"
        class="bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600 disabled:opacity-50"
      >
        スタート
      </button>
    </div>
  </template>

  <script setup>
  import { ref, onMounted } from 'vue'
  import api from '@/api'

  const timer = ref(600)
  const isRunning = ref(false)
  const selectedUserId = ref('')
  const users = ref([])
  const tasks = ref([])

  onMounted(() => {
    fetchUsers()
    fetchTasks()
  })

  const fetchUsers = async () => {
    const res = await api.fetchUsers()
    users.value = res.data
  }

  const fetchTasks = async () => {
    const res = await api.client.get('/tasks')
    tasks.value = res.data
  }

  const shuffleTasks = async () => {
    try {
      const res = await api.client.post('/tasks/shuffle')
      tasks.value = res.data.tasks
      alert('シャッフル完了！')
    } catch (e) {
      console.error('シャッフルエラー', e)
      alert('シャッフルに失敗しました')
    }
  }

  const formatTime = () => {
    const min = String(Math.floor(timer.value / 60)).padStart(2, '0')
    const sec = String(timer.value % 60).padStart(2, '0')
    return `${min}:${sec}`
  }

  const startTimer = () => {
    if (isRunning.value || !selectedUserId.value) return
    isRunning.value = true
    timer.value = 600
    const interval = setInterval(() => {
      if (timer.value > 0) {
        timer.value--
      } else {
        clearInterval(interval)
        isRunning.value = false
        alert('🕓 掃除完了です！履歴を登録します。')
        submitHistory()
      }
    }, 1000)
  }

  const submitHistory = async () => {
    try {
      const task = tasks.value.find(t => t.user_id === selectedUserId.value)
      if (!task) {
        alert('該当タスクが見つかりませんでした')
        return
      }

      await api.client.post('/task-histories', {
        user_id: selectedUserId.value,
        task_id: task.id,
        remarks: 'タイマー完了により自動登録'
      })
    } catch (e) {
      console.error('履歴登録エラー:', e)
      alert('履歴登録中にエラーが発生しました。')
    }
  }
  </script>
