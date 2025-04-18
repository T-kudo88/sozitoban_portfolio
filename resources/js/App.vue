<script setup lang="ts">
import { ref } from 'vue'
import TaskList from './Components/TaskList.vue'
import Timer from './Components/Timer.vue'
import { initAuth, fetchUsers } from '@/api'

onMounted(async () => {
  await initAuth()  // ✅ Cookieを取得して認証の準備
  const res = await fetchUsers()
  console.log(res.data)
})

const selectedTask = ref(null)

// TaskList から emit されたタスクを受け取る
const handleTaskSelect = (task: any) => {
    selectedTask.value = task
}
</script>

<template>
    <h1>🧼 Cleaning App</h1>

    <!-- タスク一覧 -->
    <TaskList @select-task="handleTaskSelect" />

    <!-- 選択されたタスクを表示（Timer.vue） -->
    <Timer v-if="selectedTask" :task="selectedTask" />
</template>
