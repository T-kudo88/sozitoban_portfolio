<script setup lang="ts">
import { ref } from 'vue'
import axios from 'axios'

const title = ref('')
const message = ref('')

// 🔍 トークン確認ログ
console.log('✅ トークンの確認:', import.meta.env.VITE_API_TOKEN)

const token = import.meta.env.VITE_API_TOKEN

const submitTask = async () => {
  if (!title.value.trim()) {
    message.value = 'タイトルを入力してください'
    console.log('💡 token:', token)
    console.log('💡 送信データ:', {
  area: title.value
})
    return
  }

  try {
    await axios.post('http://127.0.0.1:8000/api/tasks', {
  area: title.value,
}, {
  headers: {
    Authorization: `Bearer ${token}`,
  }
});
    message.value = '✅ タスクを作成しました'
    title.value = '' // 入力欄クリア
  } catch (err) {
    message.value = '❌ タスクの作成に失敗しました'
    console.error(err)
  }
}
</script>

<template>
  <div>
    <h3>🆕 タスク追加フォーム</h3>
    <form @submit.prevent="submitTask">
      <input v-model="title" type="text" placeholder="タスク名を入力" />
      <button type="submit">作成</button>
    </form>
    <p>{{ message }}</p>
  </div>
</template>

<style scoped>
input {
  padding: 6px;
  margin-right: 8px;
}
button {
  padding: 6px 12px;
  cursor: pointer;
}
p {
  margin-top: 8px;
  color: #555;
}
</style>
