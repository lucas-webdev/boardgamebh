# Code Style

## HTML
- Semantic HTML5
- File naming: kebab-case (`trocas-em-dinheiro.html`)
- All user-facing text in Brazilian Portuguese
- Tailwind utility classes first; inline styles as fallback
- New pages must be registered in `vite.config.js` under `build.rollupOptions.input`

## JavaScript
- Vanilla ES6+ (no framework yet)
- `DOMContentLoaded` pattern for initialization
- camelCase for variables and functions
- Template literals for HTML injection (navbar.js, footer.js pattern)
- Asset paths in JS strings must use `/public/` paths (e.g., `/img/logo/file.png`), not `/src/` paths — Vite does not transform paths inside JS strings

## CSS / SCSS
- Tailwind utility classes are the default approach
- Custom SCSS only for complex effects (parallax, animations, post content styling)
- SCSS variables: `$mainGreen: #198754`, `$mainGrey: #404248`
- `_variables.scss` is auto-imported globally via Vite preprocessor config
- Bootstrap 5 loaded via CDN `<script>` tag, not bundled

## Git
- Commits: lowercase, descriptive, in Portuguese
- Examples: `add page trocas em dinheiro`, `fix navbar mobile`, `feat: turn it into PWA`
