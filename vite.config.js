import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path'; // ✅ エイリアス設定に必要

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', // ✅ CSS もビルド対象に
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'), // ✅ `@` をエイリアスとして設定
        },
    },
    server: {
        host: '127.0.0.1', // ✅ 明示的にローカルホストを指定
        port: 5173, // ✅ Vite のデフォルトポート
        strictPort: true, // ✅ 使用中の場合はエラーを出す（別のポートを使わない）
        fs: {
            strict: false
        }
    },
});
