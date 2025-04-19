<script setup lang="ts">
import { ref, watch, onBeforeUnmount } from 'vue'
import axios from 'axios'

const props = defineProps<{
  task: {
    id: number
    area: string
    user: { id: number; name: string }
  }
}>()

const seconds = ref(0)
const isRunning = ref(false)
const isTimeUp = ref(false)
const message = ref('')
const token = import.meta.env.VITE_API_TOKEN

let timerId: ReturnType<typeof setInterval> | null = null

const startTimer = () => {
  if (isRunning.value) return
  isRunning.value = true
  isTimeUp.value = false
  seconds.value = 0

  timerId = setInterval(() => {
    seconds.value++
  }, 1000)
}

const stopTimer = async () => {
  isRunning.value = false
  if (timerId) clearInterval(timerId)

  try {
    await axios.post(
      'http://127.0.0.1:8000/api/task-histories',
      {
        task_id: props.task.id,
        area: props.task.area,
        remarks: `作業時間: ${seconds.value}秒`,
        cleaned_at: new Date().toISOString(),
      },
      {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      }
    )
    message.value = '✅ 履歴保存完了'
  } catch (err) {
    console.error('❌ 保存エラー', err)
    message.value = '❌ 履歴保存に失敗しました'
  }

  timerId = null
}

// 600秒でタイムアップ処理
watch(seconds, (newVal) => {
  if (newVal >= 600) {
    isTimeUp.value = true
    stopTimer()

    // 3秒後に非表示（自動）
    setTimeout(() => {
      isTimeUp.value = false
    }, 3000)
  }
})

// タスクが変わったときリセット
watch(() => props.task, () => {
  stopTimer()
  seconds.value = 0
  message.value = ''
  isTimeUp.value = false
})

onBeforeUnmount(() => {
  if (timerId) clearInterval(timerId)
})
</script>

<template>
  <div style="margin-top: 20px; position: relative;">
    <h2>⏱ 作業タイマー</h2>
    <p>担当エリア：{{ task.area }}（{{ task.user.name }}）</p>
    <p>経過時間：{{ seconds }} 秒</p>

    <button @click="startTimer" :disabled="isRunning">▶️ スタート</button>
    <button @click="stopTimer" :disabled="!isRunning">⏹ 停止＆保存</button>

    <p>{{ message }}</p>

    <!-- タイムアップ表示モーダル -->
    <div v-if="isTimeUp" class="overlay">
    <div v-if="isTimeUp" class="timeup-modal">
      ⏰ タイムアップ！お疲れ様でした！
      <button class="close-button" @click="isTimeUp = false">x</button>
    </div>
  </div>
</template>

<style scoped>
button {
  margin-right: 8px;
  padding: 6px 12px;
  cursor: pointer;
}

.timeup-modal {
  position: fixed;
  top: 30%;
  left: 50%;
  transform: translateX(-50%);
  background-color: #f8d7da;
  color: #721c24;
  padding: 24px 36px;
  border: 2px solid #f5c6cb;
  border-radius: 10px;
  font-size: 22px;
  font-weight: bold;
  z-index: 9999;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
}

.close-button {
  position: absolute;
  top: 8px;
  right: 12px;
  background: transparent;
  border: none;
  font-size: 20px;
  font-weight: bold;
  color: #721c24;
  cursor: pointer;
}

/* 画面全体を覆うオーバーレイ */
.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.5); /* 半透明の黒 */
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 999;
}

/* モーダル自体 */
.timeup-modal {
  background-color: #fff0f0;
  color: #721c24;
  padding: 24px 32px;
  border-radius: 10px;
  border: 2px solid #f5c6cb;
  font-size: 20px;
  font-weight: bold;
  position: relative;
  text-align: center;
}

/* ×ボタン */
.close-button {
  position: absolute;
  top: 8px;
  right: 12px;
  background: transparent;
  border: none;
  font-size: 24px;
  font-weight: bold;
  color: #721c24;
  cursor: pointer;
}
</style>
