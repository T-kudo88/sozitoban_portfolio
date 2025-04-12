<script setup lang="ts">
import { onMounted } from 'vue'
import axios from 'axios'

onMounted(async () => {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/user', {
      headers: {
        Authorization: 'Bearer 2|ELQSErfHCMQIiFH4btYAMN9ZagzcDxAD8WRutau58cd74833'
      }
    })
    console.log('✅ API Response:', response.data)
  } catch (error) {
    console.error('❌ API Error:', error)
  }
})
</script>

<template>
  <p>APIテスト中...（結果はブラウザのコンソールに表示されます）</p>
</template>
