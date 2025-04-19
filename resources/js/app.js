import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

const app = createApp(App)

// ✅ 必要な場合のみ Vue Devtools を有効にする（オプション）
app.config.devtools = true

app.use(router)
app.mount('#app')
