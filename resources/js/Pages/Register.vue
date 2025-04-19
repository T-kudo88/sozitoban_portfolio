<template>
    <div class="p-6 max-w-md mx-auto">
      <h1 class="text-2xl font-bold mb-4">登録画面</h1>

      <form @submit.prevent="submit">
        <div class="mb-3">
          <label>社員番号</label>
          <input v-model="form.employee_id" type="text" class="border w-full p-2" />
          <p v-if="errors.employee_id" class="text-red-500">{{ errors.employee_id }}</p>
        </div>

        <div class="mb-3">
          <label>社員名</label>
          <input v-model="form.name" type="text" class="border w-full p-2" />
          <p v-if="errors.name" class="text-red-500">{{ errors.name }}</p>
        </div>

        <div class="mb-3">
          <label>メールアドレス</label>
          <input v-model="form.email" type="email" class="border w-full p-2" />
          <p v-if="errors.email" class="text-red-500">{{ errors.email }}</p>
        </div>

        <div class="mb-3">
          <label>役職</label>
          <input v-model="form.position" type="text" class="border w-full p-2" />
          <p v-if="errors.position" class="text-red-500">{{ errors.position }}</p>
        </div>

        <div class="mb-3">
            <label for="password">パスワード</label>
            <input
                id="password"
                type="password"
                v-model="form.password"
                class="border w-full p-2"
            />
            <p v-if="errors.password" class="text-red-500">{{ errors.password }}</p>
        </div>

        <div class="flex gap-3 mt-5">
          <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">登録</button>
          <button @click="goBack" type="button" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">戻る</button>
        </div>
      </form>
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
  const errors = ref<{ [key: string]: string }>({})

  const submit = async () => {
    errors.value = {}
    try {
      await axios.post('/api/users', form.value)
      alert('登録に成功しました！')
      router.push('/') // ホーム画面へ遷移
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
