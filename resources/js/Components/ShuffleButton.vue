<template>
    <button @click="shuffle" class="bg-blue-500 text-white px-4 py-2 rounded">シャッフル</button>
  </template>

  <script setup>
  import { defineProps } from 'vue'

  const props = defineProps({
    users: Array,
    onShuffle: Function
  })

  const shuffle = () => {
    const shuffled = [...props.users].sort(() => 0.5 - Math.random())
    props.onShuffle(shuffled)
  }
  </script>
