import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { ZiggyVue } from 'ziggy-js'
import router from './router'

// ✅ ページを一括インポート（ESM用）
const pages = import.meta.glob('./Pages/**/*.vue')

createInertiaApp({
    resolve: name => pages[`./Pages/${name}.vue`](),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(router)
            .use(ZiggyVue)
            .mount(el)
    },
})
