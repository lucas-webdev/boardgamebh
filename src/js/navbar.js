/**
 * Navbar compartilhado — injeta navbar em #navbar-root
 * Importar em cada página: <script type="module" src="/src/js/navbar.js"></script>
 */

const navLinks = [
  { label: "Início", href: "/" },
  { label: "Sobre", href: "/sobre/" },
  {
    label: "Math Trade BH",
    children: [
      { label: "O que é", href: "/mathtrade-bh/o-que-e.html" },
      { label: "Regras Gerais", href: "/mathtrade-bh/regras-gerais.html" },
      { label: "FAQ", href: "/mathtrade-bh/faq.html" },
      {
        label: "Edição Atual",
        href: "/mathtrade-bh/edicao-setembro-2025.html",
      },
    ],
  },
  {
    label: "Iniciativas",
    children: [
      { label: "Joga no QG!", href: "/em-breve.html" },
      { label: "Resenha com Jogatina", href: "/em-breve.html" },
      { label: "BGBH Masters", href: "/bgbh-masters/" },
    ],
  },
  { label: "Artigos", href: "/posts/" },
  { label: "Contato", href: "/em-breve.html" },
];

function buildDesktopLinks() {
  return navLinks
    .map((link) => {
      if (link.children) {
        const items = link.children
          .map(
            (child) =>
              `<a href="${child.href}" class="text-sm block px-4 py-2 text-gray-800 hover:bg-gray-200">${child.label}</a>`
          )
          .join("");
        return `
        <div class="relative group">
          <span class="hover:text-gray-400 cursor-pointer">${link.label} <i class="bi bi-chevron-down text-xs"></i></span>
          <div class="w-48 absolute left-0 hidden mt-0 space-y-0 bg-white shadow-md rounded group-hover:block hover:block z-50">
            ${items}
          </div>
        </div>`;
      }
      return `<a href="${link.href}" class="hover:text-gray-400">${link.label}</a>`;
    })
    .join("");
}

function buildMobileLinks() {
  return navLinks
    .map((link) => {
      if (link.children) {
        const items = link.children
          .map(
            (child) =>
              `<a href="${child.href}" class="block pl-4 py-1 text-sm text-gray-300 hover:text-white">${child.label}</a>`
          )
          .join("");
        return `
        <div>
          <span class="block font-semibold">${link.label}</span>
          ${items}
        </div>`;
      }
      return `<a href="${link.href}" class="hover:text-gray-400">${link.label}</a>`;
    })
    .join("");
}

function renderNavbar() {
  const root = document.getElementById("navbar-root");
  if (!root) return;

  root.innerHTML = `
    <nav class="sticky top-0 shadow-md z-50 px-4 py-3 flex items-center justify-between h-14 bg-black border-b border-b-[#198754]">
      <!-- Logo -->
      <div class="h-full">
        <a href="/">
          <img class="h-full w-auto" src="/src/img/logo/bgbh-com-sombra.png" alt="Logo BGBH">
        </a>
      </div>

      <!-- Botão Hambúrguer (mobile) -->
      <button id="menu-toggle" class="text-white block md:hidden">
        <i class="bi bi-list text-3xl"></i>
      </button>

      <!-- Menu Mobile -->
      <div class="absolute w-full bg-black p-5 flex-col gap-4 top-0 left-0 hidden animate__animated animate__slideInDown text-white md:hidden z-50"
           id="hamburger-menu">
        <div class="flex justify-between items-center mb-2">
          <a href="/">
            <img class="h-[40px] w-auto" src="/src/img/logo/bgbh-com-sombra.png" alt="Logo BGBH">
          </a>
          <i class="bi bi-x-lg cursor-pointer text-xl" id="close-menu"></i>
        </div>
        ${buildMobileLinks()}
      </div>

      <!-- Menu Desktop -->
      <div class="hidden text-white space-x-6 md:items-center md:flex text-sm">
        ${buildDesktopLinks()}
      </div>
    </nav>
  `;

  // Hamburger toggle
  const hamburgerIcon = document.getElementById("menu-toggle");
  const closeMenuIcon = document.getElementById("close-menu");
  const menu = document.getElementById("hamburger-menu");

  if (hamburgerIcon && menu) {
    hamburgerIcon.addEventListener("click", () => {
      menu.classList.add("flex");
      menu.classList.remove("hidden");
    });
  }
  if (closeMenuIcon && menu) {
    closeMenuIcon.addEventListener("click", () => {
      menu.classList.add("hidden");
      menu.classList.remove("flex");
    });
  }
}

document.addEventListener("DOMContentLoaded", renderNavbar);
