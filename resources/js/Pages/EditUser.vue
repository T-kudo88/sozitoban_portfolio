<template>
    <div class="p-10 max-w-5xl mx-auto">
      <h1 class="text-3xl font-bold mb-6 text-center">編集画面</h1>

      <!-- 一覧テーブル -->
      <table class="w-full border border-collapse mb-6">
        <thead class="bg-gray-200">
          <tr>
            <th class="border px-4 py-2 text-center"></th>
            <th class="border px-4 py-2 text-center">社員番号</th>
            <th class="border px-4 py-2 text-center">社員名</th>
            <th class="border px-4 py-2 text-center">メールアドレス</th>
            <th class="border px-4 py-2 text-center">役職</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id">
            <td class="border px-4 py-2 text-center">
              <input type="checkbox" v-model="selectedIds" :value="user.id" />
            </td>
            <td class="border px-4 py-2 text-center">{{ user.employee_number }}</td>
            <td class="border px-4 py-2 text-center">{{ user.name }}</td>
            <td class="border px-4 py-2 text-center">{{ user.email }}</td>
            <td class="border px-4 py-2 text-center">{{ user.position }}</td>
          </tr>
        </tbody>
      </table>

      <!-- ボタン -->
      <div class="flex justify-between">
        <router-link
          to="/"
          class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400"
        >
          戻る
        </router-link>
        <button
          @click="deleteSelected"
          class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600"
        >
          削除
        </button>
      </div>
    </div>
  </template>

  <script setup>
  import { ref, onMounted } from 'vue'
  import api from '@/api'

  const users = ref([])
  const selectedIds = ref([])

  onMounted(async () => {
    const res = await api.fetchUsers()
    users.value = res.data
  })

  const deleteSelected = async () => {
    if (selectedIds.value.length === 0) {
      alert('削除するユーザーを選択してください')
      return
    }

    if (!confirm('選択されたユーザーを削除しますか？')) return

    try {
      for (const id of selectedIds.value) {
        await api.client.delete(`/users/${id}`)
      }
      alert('削除しました')
      // 再取得
      const res = await api.fetchUsers()
      users.value = res.data
      selectedIds.value = []
    } catch (err) {
      console.error(err)
      alert('削除に失敗しました')
    }
  }
  </script>
