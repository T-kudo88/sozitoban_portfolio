<!-- src/components/ShuffleButton.vue -->
<template>
    <div style="margin: 16px 0;">
      <button @click="shuffleTasks" :disabled="loading">
        {{ loading ? 'シャッフル中...' : '🌀 担当をシャッフル' }}
      </button>
      <p v-if="message">{{ message }}</p>
    </div>
  </template>

  <script setup lang="ts">
  import { ref } from 'vue'
  import axios from 'axios'

  const loading = ref(false)
  const message = ref('')
  const token = import.meta.env.VITE_API_TOKEN

  const shuffleTasks = async () => {
    loading.value = true
    message.value = ''

    try {
      const res = await axios.post('http://127.0.0.1:8000/api/tasks/shuffle', {}, {
        headers: {
          Authorization: `Bearer ${token}`,
        }
      })

      message.value = res.data.message || '✅ シャッフル成功'
      // ✅ イベントや emit 使わず、location.reload で再取得（シンプルに）
      setTimeout(() => location.reload(), 1000)

    } catch (err) {
      message.value = '❌ シャッフル失敗'
      console.error(err)
    } finally {
      loading.value = false
    }
  }
  </script>

  <style scoped>
  button {
    padding: 8px 14px;
    font-size: 16px;
    background: #409eff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  button:disabled {
    opacity: 0.6;
    cursor: not-allowed;
  }
  p {
    margin-top: 8px;
    color: #555;
  }
  </style>
