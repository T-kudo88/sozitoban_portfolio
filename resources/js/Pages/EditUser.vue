<template>
    <div class="min-h-screen flex flex-col items-center py-10 bg-white">
      <!-- タイトル -->
      <h1 class="text-3xl font-bold border px-10 py-2 mb-6">編集画面</h1>

      <!-- 表の枠 -->
      <div class="border border-black w-[900px] p-6 bg-white">
        <!-- 表 -->
        <table class="table-fixed w-full border border-collapse text-center mb-6">
          <thead class="bg-gray-100">
            <tr>
              <th class="border px-2 py-2 w-12"></th>
              <th class="border px-4 py-2">社員番号</th>
              <th class="border px-4 py-2">社員名</th>
              <th class="border px-4 py-2">メールアドレス</th>
              <th class="border px-4 py-2">役職</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users" :key="user.id">
              <td class="border px-2 py-2">
                <input type="checkbox" v-model="selected" :value="user.id" />
              </td>
              <td class="border px-4 py-2">{{ user.employee_id }}</td>
              <td class="border px-4 py-2">{{ user.name }}</td>
              <td class="border px-4 py-2">{{ user.email }}</td>
              <td class="border px-4 py-2">{{ user.position }}</td>
            </tr>
          </tbody>
        </table>

        <!-- ボタン -->
        <div class="flex justify-between">
          <button @click="deleteUsers" class="bg-red-400 text-white px-6 py-2 rounded hover:bg-red-500">削除</button>
          <button @click="goBack" class="bg-sky-400 text-white px-6 py-2 rounded hover:bg-sky-500">戻る</button>
        </div>
      </div>
    </div>
  </template>

  <script setup lang="ts">
  import { ref, onMounted } from 'vue'
  import axios from 'axios'
  import { useRouter } from 'vue-router'

  const users = ref([])
  const selected = ref<number[]>([])
  const router = useRouter()

  // ユーザー一覧取得
  const getUsers = async () => {
    const res = await axios.get('/api/users')
    users.value = res.data
  }

  // 削除処理
  const deleteUsers = async () => {
    if (selected.value.length === 0) {
      alert('削除するユーザーを選択してください')
      return
    }

    if (!confirm('本当に削除しますか？')) return

    try {
      await axios.post('/api/users/bulk-delete', {
        ids: selected.value,
      })
      alert('削除しました！')
      await getUsers()
      selected.value = []
    } catch (error) {
      alert('削除に失敗しました')
      console.error(error)
    }
  }

  const goBack = () => {
    router.push('/')
  }

  onMounted(() => {
    getUsers()
  })
  </script>
