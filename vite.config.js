import { defineConfig } from "vite";
import { resolve } from "path";

export default defineConfig({
  base: "/",
  resolve: {
    alias: {
      "@": resolve(__dirname, "src"),
    },
  },
  build: {
    outDir: "dist",
    rollupOptions: {
      input: {
        main: resolve(__dirname, "index.html"),
        "sobre/": resolve(__dirname, "em-breve.html"),
        "bgbh-masters/": resolve(__dirname, "bgbh-masters/index.html"),
        "em-breve": resolve(__dirname, "em-breve.html"),
        "mathtrade-bh/o-que-e": resolve(__dirname, "mathtrade-bh/o-que-e.html"),
        "mathtrade-bh/faq/": resolve(__dirname, "mathtrade-bh/faq.html"),
        "mathtrade-bh/edicao-novembro-2024": resolve(
          __dirname,
          "mathtrade-bh/edicao-novembro-2024.html",
        ),
        "mathtrade-bh/edicao-novatos": resolve(
          __dirname,
          "mathtrade-bh/edicao-novatos.html",
        ),
        "mathtrade-bh/regras-gerais": resolve(
          __dirname,
          "mathtrade-bh/regras-gerais.html",
        ),
        "mathtrade-bh/edicao-setembro-2025": resolve(
          __dirname,
          "mathtrade-bh/edicao-setembro-2025.html",
        ),
        "mathtrade-bh/trocas-em-dinheiro": resolve(
          __dirname,
          "mathtrade-bh/trocas-em-dinheiro.html",
        ),
        "posts/": resolve(__dirname, "posts/index.html"),
        "posts/post": resolve(__dirname, "posts/post.html"),
      },
    },
  },
  css: {
    preprocessorOptions: {
      scss: {
        additionalData: `@use "@/styles/_variables.scss" as *;`,
      },
    },
  },
});
