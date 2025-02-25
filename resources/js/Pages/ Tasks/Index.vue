<template>
    <div>
        <h1>掃除当番一覧</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>担当者</th>
                    <th>担当エリア</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="task in tasks" :key="task.id">
                    <td>{{ task.id }}</td>
                    <td>{{ task.user.name }}</td>
                    <td>{{ task.area }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';

defineProps({
    tasks: Array
});
</script>
