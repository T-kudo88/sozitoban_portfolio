<template>
    <div>
        <h1 class="text-2xl font-bold">掃除履歴</h1>
        <table class="border-collapse border border-gray-500 w-full mt-4">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-400 p-2">ID</th>
                    <th class="border border-gray-400 p-2">ユーザーID</th>
                    <th class="border border-gray-400 p-2">タスクID</th>
                    <th class="border border-gray-400 p-2">完了日時</th>
                    <th class="border border-gray-400 p-2">備考</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="history in histories" :key="history.id">
                    <td class="border border-gray-400 p-2">{{ history.id }}</td>
                    <td class="border border-gray-400 p-2">{{ history.user_id }}</td>
                    <td class="border border-gray-400 p-2">{{ history.task_id }}</td>
                    <td class="border border-gray-400 p-2">{{ history.completed_at }}</td>
                    <td class="border border-gray-400 p-2">{{ history.remarks }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { getTaskHistories } from "@/api";

const histories = ref([]);

onMounted(async () => {
    try {
        const response = await getTaskHistories();
        histories.value = response.data;
    } catch (error) {
        console.error("APIエラー:", error);
        alert("履歴データの取得に失敗しました。");
    }
});
</script>
