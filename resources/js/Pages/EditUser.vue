<template>
    <div class="p-10 max-w-6xl mx-auto text-center">
      <h1 class="text-4xl font-bold mb-8">編集画面</h1>

      <div class="overflow-x-auto">
        <form @submit.prevent="deleteSelectedUsers">
          <table class="table-auto min-w-full border border-collapse mb-6 text-sm">
            <thead class="bg-gray-200">
              <tr>
                <th class="border px-2 py-2 w-12 text-center">✔</th>
                <th class="border px-4 py-2 text-left">社員番号</th>
                <th class="border px-4 py-2 text-left">社員名</th>
                <th class="border px-4 py-2 text-left">メールアドレス</th>
                <th class="border px-4 py-2 text-left">役職</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="user in users" :key="user.id" class="hover:bg-gray-50">
                <td class="border px-2 py-2 text-center">
                  <input type="checkbox" v-model="selected" :value="user.id" />
                </td>
                <td class="border px-4 py-2">{{ user.id }}</td>
                <td class="border px-4 py-2">{{ user.name }}</td>
                <td class="border px-4 py-2">{{ user.email }}</td>
                <td class="border px-4 py-2">{{ user.position }}</td>
              </tr>
            </tbody>
          </table>

          <div class="flex justify-center gap-4">
            <button
              type="submit"
              class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600 transition"
            >
              削除
            </button>
            <router-link to="/">
              <button
                type="button"
                class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500 transition"
              >
                戻る
              </button>
            </router-link>
          </div>
        </form>
      </div>
    </div>
  </template>

  <script setup lang="ts">
  import { ref, onMounted } from 'vue'
  import { fetchUsers, deleteUsers } from '@/api' // 適宜ルート修正

  const users = ref([])
  const selected = ref<number[]>([])

  const getUsers = async () => {
    const res = await fetchUsers()
    users.value = res.data
  }

  const deleteSelectedUsers = async () => {
    if (!confirm('本当に削除しますか？')) return
    try {
      await deleteUsers(selected.value)
      await getUsers()
      selected.value = []
      alert('削除しました！')
    } catch (e) {
      console.error(e)
      alert('削除に失敗しました')
    }
  }

  onMounted(() => {
    getUsers()
  })
  </script>
