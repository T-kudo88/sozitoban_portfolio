<script setup lang="ts">
import { ref, onMounted } from 'vue'
import axios from 'axios'

interface Task {
  id: number
  area: string
  created_at: string
  user: {
    id: number
    name: string
    email: string
  }
}

const tasks = ref<Task[]>([])
const loading = ref(true)
const error = ref('')
const token = import.meta.env.VITE_API_TOKEN

const fetchTasks = async () => {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/tasks', {
      headers: {
        Authorization: `Bearer ${token}`,
      }
    })
    tasks.value = response.data
  } catch (err) {
    error.value = 'タスク取得に失敗しました'
    console.error(err)
  } finally {
    loading.value = false
  }
}

onMounted(fetchTasks)
</script>

<template>
  <div>
    <h2>🧹 担当者一覧</h2>
    <div v-if="loading">読み込み中...</div>
    <div v-if="error">{{ error }}</div>
    <table v-if="!loading && !error">
      <thead>
        <tr>
          <th>担当者</th>
          <th>担当エリア</th>
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

<style scoped>
table {
  border-collapse: collapse;
  width: 100%;
}
th, td {
  border: 1px solid #ccc;
  padding: 8px;
  text-align: left;
}
</style>
