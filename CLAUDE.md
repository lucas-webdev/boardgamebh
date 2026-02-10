# CLAUDE.md - BoardgameBH Project Guide

## Project Overview

Static multi-page website for **BoardgameBH (BGBH)**, a Brazilian board game community portal.
- **Repo:** https://github.com/lucas-webdev/boardgamebh
- **Production:** https://bgbh.com.br
- Built with Vite + Tailwind CSS + SCSS. All content is in Brazilian Portuguese.

## Tech Stack

- **Build:** Vite 6
- **CSS:** Tailwind CSS 3 + SCSS (Sass)
- **JS:** Vanilla ES6+ (no framework)
- **Icons:** Bootstrap Icons
- **Animations:** Animate.css, AOS (Animate on Scroll)
- **CDN deps:** jQuery 3.5.1, Bootstrap 5
- **Analytics:** Google Analytics, GTM, Firebase
- **Package manager:** Yarn
- **Node requirement:** > 20

## Common Commands

```bash
yarn dev        # Start dev server with hot reload
yarn build      # Production build → dist/
yarn preview    # Preview production build
yarn lint       # Run ESLint
```

## Project Structure

```
├── index.html                       # Homepage
├── em-breve.html                    # Coming soon page
├── sobre/index.html                 # About page
├── bgbh-masters/index.html          # Masters tournament page
├── mathtrade-bh/                    # MathTrade event pages
│   ├── o-que-e.html
│   ├── faq.html
│   ├── regras-gerais.html
│   ├── trocas-em-dinheiro.html
│   ├── edicao-novatos.html
│   ├── edicao-novembro-2024.html
│   └── edicao-setembro-2025.html
├── src/
│   ├── js/main.js                   # Mobile menu logic
│   ├── js/home.js                   # Carousel/slider
│   └── styles/
│       ├── main.scss                # Custom styles
│       └── _variables.scss          # SCSS variables ($mainGreen, $mainGrey)
├── public/
│   ├── img/                         # Static images
│   └── js/scripts.js                # Minimal public script
├── vite.config.js                   # Multi-page build config with aliases
├── tailwind.config.js               # Content paths + custom fonts
└── postcss.config.js                # postcss-import, tailwind, autoprefixer
```

## Build Configuration

- **Vite** is configured for multi-page mode — each HTML page is an explicit input in `vite.config.js`
- `@` alias points to `src/`
- SCSS variables from `_variables.scss` are auto-imported via Vite preprocessor options
- Output goes to `dist/`

## Coding Conventions

- **Language:** All user-facing text is in Brazilian Portuguese
- **File naming:** kebab-case (`trocas-em-dinheiro.html`)
- **JS style:** Vanilla ES6+, `DOMContentLoaded` pattern, camelCase variables
- **CSS approach:** Tailwind utility classes first; custom SCSS only for complex effects (parallax, animations)
- **SCSS variables:** `$mainGreen: #198754`, `$mainGrey: #404248`
- **HTML:** Semantic HTML5, mix of Tailwind classes and some inline styles
- **Git commits:** Lowercase, descriptive, in Portuguese (e.g., `add page trocas em dinheiro`)

## Deployment

- GitHub Actions CI/CD on push to `main`
- Builds with Node 22 + Yarn, then deploys `dist/` to FTP via `SamKirkland/FTP-Deploy-Action`

## Important Notes

- When adding new pages, register them in `vite.config.js` under `build.rollupOptions.input`
- Tailwind scans `./**/*.html` and `./src/**/*.{html,js,scss}` for class usage
- CDN libraries (Bootstrap, jQuery, AOS) are loaded via `<script>` tags in HTML, not bundled

## Agent Behavior

- Act as a senior frontend developer. Be objective and pragmatic.
- Respect the existing stack and project decisions. Do not suggest changing frameworks or stack unless explicitly asked.
- Work incrementally — never rewrite everything without request.
- Follow existing patterns in the repository.
- Prefer showing solutions with brief explanations. Avoid unnecessary abstractions and overengineering.
- Readability and maintainability first.
- Do not add dependencies without justification.
- Before suggesting major changes, explain benefits, impact and trade-offs.

## React Migration (Planned)

The project will migrate from vanilla HTML/JS to React. When working on new features or refactoring, follow these React conventions:

- Functional components only — no class components
- Hooks over classes (useState, useEffect, useContext, custom hooks)
- Component files in PascalCase (`EventCard.jsx`)
- Keep components small and focused on a single responsibility
- Co-locate component styles, tests and helpers when possible
- Use React Router for page navigation (replacing multi-page HTML)
- Maintain Tailwind CSS as the primary styling approach
- Vite remains as the build tool (supports React via `@vitejs/plugin-react`)
