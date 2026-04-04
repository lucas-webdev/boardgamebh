# BoardgameBH [BGBH]

Portal da comunidade de jogos de tabuleiro de Belo Horizonte.

**Produção:** [bgbh.com.br](https://bgbh.com.br)

## Tech Stack

- **Build:** Vite 6 (multi-page)
- **CSS:** Tailwind CSS 3 + SCSS (Sass)
- **JS:** Vanilla ES6+
- **Icons:** Bootstrap Icons
- **Animations:** Animate.css, AOS
- **CDN:** Bootstrap 5, jQuery 3.5.1
- **Analytics:** Google Analytics, GTM, Firebase
- **PWA:** Manifest + Service Worker (instalável como app)

## Pré-requisitos

- Node.js > 20
- Yarn

## Instalação e uso

```bash
# Instalar dependências
yarn install

# Servidor de desenvolvimento
yarn dev

# Build de produção (saída em dist/)
yarn build

# Preview do build
yarn preview

# Lint
yarn lint
```

## Estrutura do projeto

```
├── index.html                        # Homepage
├── em-breve.html                     # Página "em breve"
├── sobre/index.html                  # Sobre
├── bgbh-masters/index.html           # Torneio BGBH Masters
├── mathtrade-bh/                     # Páginas do Math Trade
│   ├── o-que-e.html
│   ├── faq.html
│   ├── regras-gerais.html
│   ├── trocas-em-dinheiro.html
│   ├── edicao-novatos.html
│   ├── edicao-novembro-2024.html
│   └── edicao-setembro-2025.html
├── posts/                            # Blog / artigos
│   ├── index.html
│   └── *.html
├── src/
│   ├── js/                           # Scripts (navbar, footer, posts, home)
│   └── styles/                       # SCSS (main.scss, _variables.scss)
├── public/
│   ├── img/                          # Imagens estáticas
│   ├── pwa/                          # Ícones do PWA
│   ├── manifest.json                 # Web App Manifest
│   └── sw.js                         # Service Worker
├── vite.config.js                    # Config multi-page com aliases
├── tailwind.config.js                # Paths de conteúdo + fontes
└── postcss.config.js                 # postcss-import, tailwind, autoprefixer
```

## Deploy

CI/CD via GitHub Actions: push na `main` dispara build e deploy FTP automático para o servidor de produção.

## Licença

MIT
