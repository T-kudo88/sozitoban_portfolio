<template>
    <div class="p-6 max-w-4xl mx-auto">
      <h1 class="text-2xl font-bold mb-4">編集画面</h1>

      <form @submit.prevent="deleteUsers">
        <table class="w-full border border-collapse mb-4">
          <thead class="bg-gray-100">
            <tr>
              <th class="border px-4 py-2">選択</th>
              <th class="border px-4 py-2">社員番号</th>
              <th class="border px-4 py-2">社員名</th>
              <th class="border px-4 py-2">メールアドレス</th>
              <th class="border px-4 py-2">役職</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users" :key="user.id">
              <td class="border px-4 py-2 text-center">
                <input type="checkbox" :value="user.id" v-model="selected" />
              </td>
              <td class="border px-4 py-2">{{ user.employee_id ?? 'N/A' }}</td>
              <td class="border px-4 py-2">{{ user.name }}</td>
              <td class="border px-4 py-2">{{ user.email }}</td>
              <td class="border px-4 py-2">{{ user.position }}</td>
            </tr>
          </tbody>
        </table>

        <div class="flex gap-3">
          <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
            削除
          </button>
          <button type="button" @click="router.push('/')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            戻る
          </button>
        </div>
      </form>
    </div>
  </template>

  <script setup lang="ts">
  import { ref, onMounted } from 'vue'
  import axios from 'axios'
  import { useRouter } from 'vue-router'

  const router = useRouter()
  const users = ref([])
  const selected = ref<number[]>([])

  const getUsers = async () => {
    const res = await axios.get('/api/users')
    users.value = res.data
  }

  const deleteUsers = async () => {
    if (selected.value.length === 0) {
      alert('削除対象を選択してください')
      return
    }
    const confirmDelete = confirm('選択したユーザーを削除しますか？')
    if (!confirmDelete) return

    try {
      await axios.post('/api/users/delete', { ids: selected.value })
      alert('削除しました')
      await getUsers()
      selected.value = []
    } catch (e) {
      alert('削除に失敗しました')
    }
  }

  onMounted(getUsers)
  </script>
