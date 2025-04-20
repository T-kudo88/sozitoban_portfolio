import './bootstrap'; // もし使っていれば
import '../css/app.css'; // ✅ Tailwind CSS 読み込み ←これを追加
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

const app = createApp(App)

app.config.devtools = true

app.use(router)
app.mount('#app')
