<template>
    <div class="p-6 max-w-3xl mx-auto">
      <h1 class="text-2xl font-bold mb-4">編集画面</h1>

      <form @submit.prevent="deleteSelected">
        <table class="w-full table-auto border">
          <thead>
            <tr class="bg-gray-200">
              <th class="p-2">選択</th>
              <th class="p-2">社員番号</th>
              <th class="p-2">氏名</th>
              <th class="p-2">メール</th>
              <th class="p-2">役職</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users" :key="user.id">
              <td class="text-center">
                <input type="checkbox" v-model="selectedIds" :value="user.id" />
              </td>
              <td class="p-2">{{ user.id }}</td>
              <td class="p-2">{{ user.name }}</td>
              <td class="p-2">{{ user.email }}</td>
              <td class="p-2">{{ user.position }}</td>
            </tr>
          </tbody>
        </table>

        <button
          type="submit"
          class="mt-4 bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700"
          :disabled="selectedIds.length === 0"
        >
          削除
        </button>
      </form>
    </div>
  </template>

  <script setup>
  import { ref, onMounted } from 'vue'
  import api from '@/api'

  const users = ref([])
  const selectedIds = ref([])

  const fetchAllUsers = async () => {
    try {
      const res = await api.fetchUsers()
      users.value = res.data
    } catch (e) {
      console.error('ユーザー取得失敗', e)
    }
  }

  const deleteSelected = async () => {
    if (!confirm('本当に削除してもよいですか？')) return

    for (const id of selectedIds.value) {
      await api.deleteUser(id)
    }

    await fetchAllUsers()
    selectedIds.value = []
  }

  onMounted(fetchAllUsers)
  </script>
