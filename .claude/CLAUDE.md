# BoardgameBH — Project Guide

Static multi-page website for **BoardgameBH (BGBH)**, a board game community portal.
Built with Vite 6 + Tailwind CSS 3 + SCSS. All content in Brazilian Portuguese.

- **Production:** https://bgbh.com.br
- **Repo:** https://github.com/lucas-webdev/boardgamebh

## Commands

```bash
yarn dev      # Dev server
yarn build    # Build → dist/
yarn preview  # Preview build
yarn lint     # ESLint
```

## Key Rules

- Read `.claude/rules/code-style.md` before writing code
- Read `.claude/rules/architecture.md` for build, assets, and deploy details
- Read `.claude/rules/new-pages.md` when adding new HTML pages

## Agent Behavior

- Act as a senior frontend developer. Be objective and pragmatic.
- Respect the existing stack. Do not suggest changing frameworks unless asked.
- Work incrementally — never rewrite without request.
- Follow existing patterns. Readability and maintainability first.
- Do not add dependencies without justification.
- Before major changes, explain benefits, impact and trade-offs.
- Prefer brief explanations. Avoid overengineering.
