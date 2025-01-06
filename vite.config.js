import { defineConfig } from "vite";
import { resolve } from "path";

export default defineConfig({
  base: "2025/",
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
        sobre: resolve(__dirname, "sobre/index.html"),
        "em-breve": resolve(__dirname, "em-breve.html"),
        "mathtrade-bh/o-que-e": resolve(__dirname, "mathtrade-bh/o-que-e.html"),
        "mathtrade-bh/regras-gerais": resolve(
          __dirname,
          "mathtrade-bh/regras-gerais.html"
        ),
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
