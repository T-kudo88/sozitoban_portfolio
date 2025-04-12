<script setup lang="ts">
import { ref, onMounted } from 'vue'
import axios from 'axios'

const tasks = ref([])
const message = ref('')
const token = import.meta.env.VITE_API_TOKEN

// 🔁 初期読み込み
const fetchTasks = async () => {
  try {
    const res = await axios.get('http://127.0.0.1:8000/api/tasks', {
      headers: {
        Authorization: `Bearer ${token}`
      }
    })
    tasks.value = res.data
  } catch (err) {
    console.error('❌ タスク取得失敗:', err)
    message.value = 'タスク取得に失敗しました'
  }
}

// 🔁 シャッフル
const shuffleTasks = async () => {
  try {
    const res = await axios.post('http://127.0.0.1:8000/api/tasks/shuffle', {}, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    })
    tasks.value = res.data.tasks
    message.value = '✅ シャッフル完了！'
  } catch (err) {
    console.error('❌ シャッフル失敗:', err)
    message.value = '❌ シャッフルに失敗しました'
  }
}

onMounted(fetchTasks)
</script>

<template>
  <div>
    <h2>🧹 掃除当番一覧</h2>
    <button @click="shuffleTasks">🔀 シャッフル</button>
    <p>{{ message }}</p>

    <table border="1">
      <thead>
        <tr>
          <th>担当者</th>
          <th>掃除場所</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="task in tasks" :key="task.id">
          <td>{{ task.user?.name || '未割り当て' }}</td>
          <td>{{ task.area }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
