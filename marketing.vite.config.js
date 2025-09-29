import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import { copyFile } from 'node:fs/promises';
import { dirname, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);
const marketingRoot = resolve(__dirname, 'resources/js/marketing');

function duplicateIndexTo404() {
    return {
        name: 'duplicate-index-to-404',
        apply: 'build',
        async closeBundle() {
            const outDir = resolve(__dirname, 'dist');
            const indexPath = resolve(outDir, 'index.html');
            const fallbackPath = resolve(outDir, '404.html');

            await copyFile(indexPath, fallbackPath);
        },
    };
}

export default defineConfig({
    root: marketingRoot,
    base: './',
    plugins: [vue(), duplicateIndexTo404()],
    build: {
        outDir: resolve(__dirname, 'dist'),
        emptyOutDir: true,
    },
});
