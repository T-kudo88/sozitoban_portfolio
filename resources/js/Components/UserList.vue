<template>
    <div>
      <h2>ユーザー一覧</h2>
      <ul>
        <li v-for="user in users" :key="user.id">
          {{ user.name }} ({{ user.email }})
        </li>
      </ul>
    </div>
  </template>

  <script setup>
  import { ref, onMounted } from "vue";
  import apiClient, { setAuthToken } from "../api";

  // ユーザー一覧データ
  const users = ref([]);

  // VueコンポーネントがマウントされたらAPIを呼び出す
  onMounted(async () => {
    try {
      // 認証トークンをセット（Tinkerで取得したトークンを使う）
      setAuthToken("2|aZW2XI8YTEpdbeGa0TTeQePw0aYXcpACJgS7gliA91f775cb");

      // APIからユーザー一覧を取得
      const response = await apiClient.get("/users");
      users.value = response.data;
    } catch (error) {
      console.error("APIエラー:", error);
    }
  });
  </script>
