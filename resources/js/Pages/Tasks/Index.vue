<template>
    <div>
        <h1>掃除当番リスト</h1>
        <ul>
            <li v-for="task in tasks" :key="task.id">
                {{ task.area }} - {{ task.user ? task.user.name : '未割り当て' }}
            </li>
        </ul>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const tasks = ref([]);
const token = localStorage.getItem('token'); // 🔹 ローカルストレージからトークン取得

const fetchTasks = async () => {
    // ✅ トークンがない場合の処理を追加
    if (!token) {
        console.error('❌ 認証トークンがありません。ログインしてください。');
        alert('認証が必要です。ログインページに移動します。');
        window.location.href = '/login';
        return;
    }

    try {
        const response = await axios.get('/api/tasks', {
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: 'application/json',
            },
        });
        tasks.value = response.data;
    } catch (error) {
        console.error('❌ タスク取得エラー:', error);

        // ✅ 401エラー（認証エラー）の場合
        if (error.response && error.response.status === 401) {
            console.error('⚠️ 認証エラー: トークンが無効または期限切れです。');
            alert('セッションが切れました。再度ログインしてください。');

            // 🔹 無効なトークンを削除してログイン画面へリダイレクト
            localStorage.removeItem('token');
            window.location.href = '/login';
        }
    }
};

// 🔹 ページが読み込まれたら `fetchTasks()` を実行
onMounted(fetchTasks);
</script>
