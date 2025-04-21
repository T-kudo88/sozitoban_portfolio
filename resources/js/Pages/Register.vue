<template>
    <div class="min-h-screen flex flex-col items-center py-10 bg-white">

      <!-- タイトル -->
      <h1 class="text-3xl font-bold border border-black px-10 py-2 mb-8">登録画面</h1>

      <!-- 入力フォーム枠 -->
      <div class="border border-black w-[500px] p-8 bg-white">

        <form @submit.prevent="submit" class="space-y-6">

          <div>
            <label class="block mb-1 font-semibold">社員番号</label>
            <input v-model="form.employee_id" type="text"
              class="border border-gray-400 w-full p-2 rounded" placeholder="社員番号を入力してください" />
            <p v-if="errors.employee_id" class="text-red-500 text-sm mt-1">{{ errors.employee_id }}</p>
          </div>

          <div>
            <label class="block mb-1 font-semibold">社員名</label>
            <input v-model="form.name" type="text"
              class="border border-gray-400 w-full p-2 rounded" placeholder="社員名を入力してください" />
            <p v-if="errors.name" class="text-red-500 text-sm mt-1">{{ errors.name }}</p>
          </div>

          <div>
            <label class="block mb-1 font-semibold">メールアドレス</label>
            <input v-model="form.email" type="email"
              class="border border-gray-400 w-full p-2 rounded" placeholder="メールアドレスを入力してください" />
            <p v-if="errors.email" class="text-red-500 text-sm mt-1">{{ errors.email }}</p>
          </div>

          <div>
            <label class="block mb-1 font-semibold">役職</label>
            <input v-model="form.position" type="text"
              class="border border-gray-400 w-full p-2 rounded" placeholder="役職を入力してください" />
            <p v-if="errors.position" class="text-red-500 text-sm mt-1">{{ errors.position }}</p>
          </div>

          <!-- 追加するパスワード欄 -->
<div class="mb-4">
  <label class="block mb-1 font-bold">パスワード</label>
  <input
    type="password"
    v-model="form.password"
    class="w-full px-3 py-2 border border-gray-300 rounded"
    placeholder="パスワードを入力してください"
  />
</div>

          <!-- ボタンエリア -->
          <div class="flex justify-between mt-8">
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">登録</button>
            <button @click="goBack" type="button" class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600">戻る</button>
          </div>
        </form>
      </div>
    </div>
  </template>

  <script setup lang="ts">
  import { ref } from 'vue'
  import { useRouter } from 'vue-router'
  import axios from 'axios'

  const router = useRouter()

  const form = ref({
    employee_id: '',
    name: '',
    email: '',
    position: '',
    password: '',
  })

  const errors = ref<{ [key: string]: string[] }>({})

  const submit = async () => {
    errors.value = {}
    try {
      await axios.post('/api/users', form.value)
      alert('登録に成功しました！')
      router.push('/')
    } catch (e: any) {
      if (e.response?.status === 422) {
        errors.value = e.response.data.errors
      } else {
        alert('登録に失敗しました')
      }
    }
  }

  const goBack = () => {
    router.push('/')
  }
  </script>
