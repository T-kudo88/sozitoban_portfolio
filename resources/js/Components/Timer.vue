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
const message = ref('')
const token = import.meta.env.VITE_API_TOKEN

let timerId: ReturnType<typeof setInterval> | null = null

const startTimer = () => {
    if (isRunning.value) return
    isRunning.value = true
    timerId = setInterval(() => {
        seconds.value++
    }, 1000)
}

const stopTimer = async () => {
    isRunning.value = false
    if (timerId) clearInterval(timerId)

    // APIで履歴を保存
    try {
        await axios.post(
            'http://127.0.0.1:8000/api/task-histories',
            {
                task_id: props.task.id,
                area: props.task.area,
                remarks: `作業時間: ${seconds.value}秒`,
                cleaned_at: new Date().toISOString(), // 任意
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

// タスクが変わったらタイマーをリセット
watch(() => props.task, () => {
    stopTimer()
    seconds.value = 0
    message.value = ''
})

onBeforeUnmount(() => {
    if (timerId) clearInterval(timerId)
})
</script>

<template>
    <div style="margin-top: 20px;">
        <h2>⏱ 作業タイマー</h2>
        <p>担当エリア：{{ task.area }}（{{ task.user.name }}）</p>
        <p>経過時間：{{ seconds }} 秒</p>

        <button @click="startTimer" :disabled="isRunning">▶️ スタート</button>
        <button @click="stopTimer" :disabled="!isRunning">⏹ 停止＆保存</button>

        <p>{{ message }}</p>
    </div>
</template>

<style scoped>
button {
    margin-right: 8px;
    padding: 6px 12px;
    cursor: pointer;
}
</style>
