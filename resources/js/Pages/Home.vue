<template>
    <div class="p-6 text-center">
      <h1 class="text-2xl font-bold mb-4">ホーム画面</h1>

      <!-- タイマー表示 -->
      <div class="text-6xl font-mono my-4">
        {{ formatTime() }}
      </div>

      <button
        @click="startTimer"
        :disabled="isRunning"
        class="bg-orange-500 text-white px-6 py-2 rounded"
      >
        スタート
      </button>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue'

  const timer = ref(600) // 10分 = 600秒
  const isRunning = ref(false)
  let interval = null

  const startTimer = () => {
    if (isRunning.value) return
    isRunning.value = true
    interval = setInterval(() => {
      if (timer.value > 0) {
        timer.value--
      } else {
        clearInterval(interval)
        isRunning.value = false
        alert('🕓 掃除完了です！')
      }
    }, 1000)
  }

  const formatTime = () => {
    const min = String(Math.floor(timer.value / 60)).padStart(2, '0')
    const sec = String(timer.value % 60).padStart(2, '0')
    return `${min}:${sec}`
  }
  </script>
