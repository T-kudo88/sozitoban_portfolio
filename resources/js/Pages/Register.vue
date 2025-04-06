<template>
    <div class="p-8 max-w-xl mx-auto">
      <h1 class="text-2xl font-bold mb-4">掃除当番の登録</h1>

      <form @submit.prevent="submit" class="space-y-4">
        <div>
          <label class="block mb-1 font-medium">エリア名</label>
          <input
            v-model="area"
            type="text"
            class="w-full border border-gray-300 rounded px-3 py-2"
            placeholder="例: トイレ, 会議室, 廊下"
            required
          />
        </div>

        <div v-if="error" class="text-red-600">{{ error }}</div>

        <button
          type="submit"
          class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        >
          登録する
        </button>
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
      alert('登録成功！')
      router.push('/')
    } catch (err) {
      console.error('登録失敗:', err)
      error.value = '登録に失敗しました'
    }
  }
  </script>
