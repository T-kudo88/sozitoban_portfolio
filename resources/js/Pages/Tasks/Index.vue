<template>
    <div>
        <h1 class="text-2xl font-bold">掃除当番リスト</h1>
        <Table :tasks="tasks" />
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Table from '@/components/Table.vue'; // ✅ コンポーネントを正しくインポート

const tasks = ref([]);

onMounted(async () => {
    try {
        const response = await axios.get('/api/tasks', {
            headers: {
                Authorization: 'Bearer 8|Yf640t0eu0lQF4dTZ6wTBh69zQiNCiOedSBaEavKcc9e45eb', // ← 最新のトークン
                Accept: 'application/json'
            },
            withCredentials: true
        });

        console.log('APIレスポンス:', response.data); // ✅ デバッグ用のログ
        tasks.value = response.data;
    } catch (error) {
        console.error('APIエラー:', error);
    }
});
</script>
