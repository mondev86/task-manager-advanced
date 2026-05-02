import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig(({ mode }) => {
  const env = loadEnv(mode, process.cwd(), '');
  const viteInDocker = env.VITE_DOCKER === '1';
  const vitePort = (() => {
    const n = Number(process.env.VITE_PORT ?? env.VITE_PORT);
    if (Number.isFinite(n) && n > 0) {
      return n;
    }
    return viteInDocker ? 5174 : 5173;
  })();

  return {
    plugins: [
      laravel({
        input: 'resources/js/app.ts',
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
        '@': path.resolve(__dirname, './resources/js'),
      },
    },
    // Vue/Vite en Docker: host + polling en bind mounts (Windows) y HMR vía localhost del navegador.
    ...(viteInDocker
      ? {
          server: {
            host: true,
            port: vitePort,
            strictPort: true,
            watch: {
              usePolling: true,
            },
            hmr: {
              host: 'localhost',
              port: vitePort,
            },
          },
        }
      : {}),
  };
});
