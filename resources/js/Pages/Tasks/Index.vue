<template>
    <div>
        <h1 class="text-2xl font-bold">掃除当番リスト</h1>
        <Table :tasks="tasks" />
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import apiClient from "@/api"; // ✅ axios を統一管理する
import Table from "@/components/Table.vue"; // ✅ パスを修正

const tasks = ref([]);

onMounted(async () => {
    try {
        // 🔹 認証トークンをセット（ローカルストレージなどから取得）
        const token = localStorage.getItem("authToken");
        if (token) {
            apiClient.defaults.headers["Authorization"] = `Bearer ${token}`;
        }

        // 🔹 APIリクエスト
        const response = await apiClient.get("/tasks");
        console.log("APIレスポンス:", response.data);
        tasks.value = response.data;
    } catch (error) {
        console.error("APIエラー:", error);

        // 🔹 ユーザーにエラーを通知
        alert("データの取得に失敗しました。");
    }
});
</script>
