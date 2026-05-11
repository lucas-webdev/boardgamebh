# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Static multi-page website for **BoardgameBH (BGBH)**, a board game community portal.
Built with Vite 6 + Tailwind CSS 3 + SCSS. All content in **Brazilian Portuguese**.

- **Production:** https://bgbh.com.br
- **Repo:** https://github.com/lucas-webdev/boardgamebh

## Commands

```bash
yarn dev      # Dev server (localhost:5173)
yarn build    # Production build → dist/
yarn preview  # Preview production build
yarn lint     # ESLint
```

## Architecture

### Build System

Vite 6 multi-page mode — every HTML page must be an explicit entry in `vite.config.js` under `build.rollupOptions.input`. The `@` alias resolves to `src/`. SCSS `_variables.scss` is auto-imported globally via Vite preprocessor config.

### Shared Components (JS Injection)

Navbar and footer are vanilla JS modules that inject HTML into root divs:
- `src/js/navbar.js` → `<div id="navbar-root">` — contains all navigation links and mobile menu logic
- `src/js/footer.js` → `<div id="footer-root">` — social links, copyright with dynamic year

Pattern: `DOMContentLoaded` → find root element → set `innerHTML` with template literal → attach event listeners. No framework.

**Note:** Some older mathtrade pages still have hardcoded inline navbars instead of using `navbar.js`.

### Post System

Posts use a two-tier data source:
1. **Primary:** PHP API at `public/api/posts.php` (MySQL database)
2. **Fallback:** Static JSON at `posts/posts.json` (graceful degradation)

Key JS modules:
- `src/js/posts.js` — loads post list, renders homepage cards, sidebar, and full listing with tag filtering
- `src/js/post-page.js` — extracts slug from URL path, fetches single post, renders content

Dynamic post URLs (`/posts/{slug}`) are rewritten by Apache `.htaccess` to serve `/posts/post.html`, which loads content via JS.

### Static Assets — Critical Distinction

- **`src/img/`** — Images in HTML `<img src>` tags. Vite transforms and hashes these.
- **`public/img/`** — Images referenced in JS template strings. Served as-is at `/img/`. **Vite does NOT transform paths inside JS strings**, so always use `/img/...` paths (not `@/img/...`).
- **`public/pwa/`** — PWA icons. Uses `/pwa/` because Apache has a built-in `/icons/` alias that shadows custom directories.

### CDN Dependencies (not bundled)

Bootstrap 5, jQuery 3.5.1, AOS (Animate on Scroll), and Google Fonts (Nunito Sans, Titillium Web) are loaded via `<script>`/`<link>` tags in HTML.

### Deployment

GitHub Actions on push to `main`: Node 22 + Yarn → `yarn build` → FTP deploy of `dist/` to `/httpdocs/`. Apache `.htaccess` strips `.html` extensions and handles post slug routing.

`public/api/config.php` contains DB credentials — it is git-ignored and blocked by `.htaccess`. Template at `config.example.php`.

## Code Style

- **HTML:** Semantic HTML5, kebab-case filenames, Tailwind utility classes first
- **JS:** Vanilla ES6+, camelCase, `DOMContentLoaded` pattern, template literals for HTML injection
- **CSS/SCSS:** Tailwind by default; custom SCSS only for complex effects (parallax, animations, `.post-content` styling). Variables: `$mainGreen: #198754`, `$mainGrey: #404248`
- **Git commits:** Lowercase, descriptive, in Portuguese (e.g., `add page trocas em dinheiro`, `fix navbar mobile`)

## Adding New Pages

See `.claude/rules/new-pages.md` for the full checklist. The critical steps: create HTML with PWA head block, include navbar/footer root divs and scripts, add SW registration, and **register the page in `vite.config.js`**.

## Agent Behavior

- Act as a senior frontend developer. Be objective and pragmatic.
- Respect the existing stack. Do not suggest changing frameworks unless asked.
- Work incrementally — never rewrite without request.
- Follow existing patterns. Do not add dependencies without justification.
- Before major changes, explain benefits, impact, and trade-offs.
