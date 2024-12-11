import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import path from 'path';

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [react()],
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'src'), // Define o alias '@' para 'src'
    },
  },
  css: {
    preprocessorOptions: {
      scss: {
        additionalData: `@use "@/styles/variables" as *;`, // Caminho absoluto correto
      },
    },
  },
  build: {
    outDir: 'dist',  // Diretório de saída onde os arquivos estáticos serão gerados
    rollupOptions: {
      input: {
        main: 'index.html',  // Arquivo HTML principal
        'quem-somos': 'src/pages/quem-somos/index.tsx',  // Rota adicional
        'mathtrade-o-que-e': 'src/pages/mathtrade/MathTrade.tsx',
        'mathtrade-regras-gerais': 'src/pages/mathtrade/RegrasGeraisMT.tsx',
        // Adicione outras rotas conforme necessário
      },
    },
  },
});

