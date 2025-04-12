<template>
    <div class="p-10 max-w-lg mx-auto">
      <h1 class="text-3xl font-bold mb-6 text-center border-b pb-2">掃除エリアの登録</h1>

      <form @submit.prevent="submit" class="space-y-6 bg-white p-6 rounded shadow">
        <!-- エリア入力 -->
        <div>
          <label class="block text-left font-semibold mb-2">エリア名</label>
          <input
            v-model="area"
            type="text"
            class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
            placeholder="例: トイレ、廊下、会議室"
            required
          />
          <p v-if="error" class="text-sm text-red-600 mt-2 ml-1">{{ error }}</p>
        </div>

        <!-- ボタン -->
        <div class="flex justify-between items-center mt-6">
          <router-link
            to="/"
            class="text-gray-600 underline hover:text-gray-800"
          >
            ← ホームに戻る
          </router-link>

          <button
            type="submit"
            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700"
          >
            登録する
          </button>
        </div>
      </form>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue'
  import apiClient from '@/api'
  import { useRouter } from 'vue-router'

  const area = ref('')
  const error = ref('')
  const router = useRouter()

  const submit = async () => {
    try {
      await apiClient.post('/tasks', {
        area: area.value
      })
      alert('登録が完了しました！')
      router.push('/')
    } catch (err) {
      console.error('登録失敗:', err)
      error.value = '登録に失敗しました'
    }
  }
  </script>
