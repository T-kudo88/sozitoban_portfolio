<template>
    <div class="p-6 text-center">
      <h1 class="text-2xl font-bold mb-4">ホーム画面</h1>

      <!-- シャッフルボタン -->
      <button @click="shuffleTasks" class="bg-blue-500 text-white px-4 py-2 mb-4 rounded">
        シャッフル
      </button>

      <!-- 担当者リスト（シャッフル結果） -->
      <div class="mb-4">
        <table class="mx-auto border border-collapse">
          <thead class="bg-gray-200">
            <tr>
              <th class="border px-4 py-2">担当者</th>
              <th class="border px-4 py-2">エリア</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="task in tasks" :key="task.id">
              <td class="border px-4 py-2">{{ task.user?.name ?? '不明' }}</td>
              <td class="border px-4 py-2">{{ task.area }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- 担当者選択 -->
      <select v-model="selectedUserId" class="border p-2 rounded mb-4">
        <option disabled value="">担当者を選んでください</option>
        <option v-for="user in users" :key="user.id" :value="user.id">
          {{ user.name }}
        </option>
      </select>

      <!-- タイマー表示 -->
      <div class="text-6xl font-mono my-4">
        {{ formatTime() }}
      </div>

      <button
        @click="startTimer"
        :disabled="isRunning || !selectedUserId"
        class="bg-orange-500 text-white px-6 py-2 rounded"
      >
        スタート
      </button>
    </div>
  </template>

  <script setup>
  import { ref, onMounted } from 'vue'
  import api from '@/api'

  const timer = ref(600) // 10分
  const isRunning = ref(false)
  const selectedUserId = ref('')

  const users = ref([])
  const tasks = ref([])

  onMounted(() => {
    fetchUsers()
    fetchTasks() // 初期表示でもタスク一覧を取得
  })

  // ユーザー一覧取得
  const fetchUsers = async () => {
    const res = await api.fetchUsers()
    users.value = res.data
  }

  // タスク一覧取得
  const fetchTasks = async () => {
    const res = await api.client.get('/tasks')
    tasks.value = res.data
  }

  // シャッフル処理（tasksをシャッフルして並び替え）
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

  // タイマー表示フォーマット
  const formatTime = () => {
    const min = String(Math.floor(timer.value / 60)).padStart(2, '0')
    const sec = String(timer.value % 60).padStart(2, '0')
    return `${min}:${sec}`
  }

  // タイマースタート
  const startTimer = () => {
    if (isRunning.value || !selectedUserId.value) return

    isRunning.value = true
    timer.value = 600 // リセットしてスタート

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

  // 履歴登録処理
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

  <style scoped>
  table {
    width: 100%;
    max-width: 600px;
  }
  </style>
