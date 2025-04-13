<script setup lang="ts">
import { ref, onBeforeUnmount } from 'vue'

const seconds = ref(0)
const isRunning = ref(false)
let timerId: ReturnType<typeof setInterval> | null = null

const startTimer = () => {
  if (isRunning.value) return
  isRunning.value = true
  timerId = setInterval(() => {
    seconds.value++
  }, 1000)
}

const stopTimer = () => {
  isRunning.value = false
  if (timerId) clearInterval(timerId)
  timerId = null
}

// タイマーが動いたまま画面を離れたとき用
onBeforeUnmount(() => {
  if (timerId) clearInterval(timerId)
})
</script>

<template>
  <div style="margin-top: 20px;">
    <h2>⏱ 作業タイマー</h2>
    <p>経過時間：{{ seconds }} 秒</p>
    <button @click="startTimer" :disabled="isRunning">▶️ スタート</button>
    <button @click="stopTimer" :disabled="!isRunning">⏹ 停止</button>
  </div>
</template>

<style scoped>
button {
  margin-right: 8px;
  padding: 6px 12px;
  cursor: pointer;
}
</style>
