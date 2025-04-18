<template>
    <div class="p-10 max-w-5xl mx-auto text-center">
      <h1 class="text-3xl font-bold mb-6">ホーム画面</h1>

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

      <!-- 🔵 シャッフルボタン追加 -->
      <div class="mb-4">
        <button @click="shuffleTasks"
          class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
          シャッフル
        </button>
      </div>
      <!-- 🟠 スタートボタン -->
<div class="mb-4">
  <button @click="startTask"
    class="bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600">
    スタート
  </button>
</div>
    </div>
  </template>

  <script setup lang="ts">
  import { ref, onMounted } from 'vue'
  import { fetchTasks, shuffleTasks, createTaskHistory } from '@/api'

const startTask = async () => {
  // 適当なユーザーを選ぶ（今回はランダムに仮選択）
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
    alert('履歴に記録しました！')
  } catch (e) {
    console.error(e)
    alert('記録に失敗しました')
  }
}

  const tasks = ref([])

  const getTasks = async () => {
    const res = await fetchTasks()
    tasks.value = res.data
  }

  // 🌀 シャッフル機能の関数
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
