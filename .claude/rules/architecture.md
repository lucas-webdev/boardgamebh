# Architecture

## Build
- Vite 6 multi-page mode — each HTML page is an explicit entry in `vite.config.js`
- `@` alias resolves to `src/`
- Output: `dist/`
- `public/` contents are copied as-is to `dist/` (no processing)

## Static assets
- Images used in JS template strings → `public/img/` (served at `/img/`)
- Images only used in HTML `<img src>` → `src/img/` (Vite transforms and hashes these)
- PWA icons → `public/pwa/` (not `/icons/` — Apache has a built-in alias that shadows it)
- Logos → `public/img/logo/`

## PWA
- `public/manifest.json` — app manifest
- `public/sw.js` — service worker (network-first HTML, cache-first assets, skips cross-origin)
- All HTML pages include manifest link, apple meta tags, and SW registration script

## CDN dependencies (loaded via `<script>` in HTML, not bundled)
- Bootstrap 5
- jQuery 3.5.1
- AOS (Animate on Scroll)
- Google Fonts (Nunito Sans, Titillium Web)

## Shared components (injected via JS)
- `src/js/navbar.js` — renders into `<div id="navbar-root">`
- `src/js/footer.js` — renders into `<div id="footer-root">`
- Older mathtrade pages still have inline navbars (not using navbar.js)

## Deployment
- GitHub Actions on push to `main`
- Builds with Node 22 + Yarn
- FTP deploy of `dist/` to `/httpdocs/` via `SamKirkland/FTP-Deploy-Action`
- Server: Apache with `.htaccess` for URL rewriting (removes .html extensions)
