<template>
    <div class="p-6">
        <h2 class="text-xl font-bold mb-4">🧹 掃除当番表</h2>
        <table class="w-full border-collapse border border-gray-500 bg-white shadow-md">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="border border-gray-500 px-6 py-3 text-center">担当エリア</th>
                    <th class="border border-gray-500 px-6 py-3 text-center">担当者</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="task in tasks" :key="task.id" class="hover:bg-gray-100">
                    <td class="border border-gray-400 px-6 py-2 text-center">{{ task.area }}</td>
                    <td class="border border-gray-400 px-6 py-2 text-center">{{ task.user ? task.user.name : '未割り当て' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
defineProps({
    tasks: Array
});
</script>
