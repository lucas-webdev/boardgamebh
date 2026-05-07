/**
 * Post dinâmico — extrai slug da URL e renderiza via API
 */

function formatDate(dateStr) {
  const date = new Date(dateStr + "T00:00:00");
  return date.toLocaleDateString("pt-BR", {
    day: "2-digit",
    month: "long",
    year: "numeric",
  });
}

function renderPost(post) {
  // Hero
  const hero = document.getElementById("post-hero");
  if (hero) {
    hero.innerHTML = `
      <img src="${post.image}" alt="${post.title}" class="w-full h-full object-cover">
      <div class="absolute inset-0 bg-black opacity-60"></div>
      <div class="absolute inset-0 flex items-end">
        <div class="max-w-[800px] mx-auto px-4 pb-8 text-white w-full">
          <div class="flex gap-2 mb-2">
            ${post.tags.map((tag) => `<span class="bg-green-700 text-xs font-medium px-2 py-0.5 rounded">${tag}</span>`).join("")}
          </div>
          <h1 class="text-2xl md:text-4xl font-extrabold leading-tight">
            ${post.title}
          </h1>
          <div class="flex items-center gap-3 mt-3 text-sm text-gray-300">
            <span>${formatDate(post.date)}</span>
            <span>&bull;</span>
            <span>Por ${post.author}</span>
          </div>
        </div>
      </div>
    `;
  }

  // Conteudo
  const content = document.getElementById("post-content");
  if (content) {
    content.innerHTML = post.content;
  }

  // Titulo da pagina
  document.title = `${post.title} — BGBH`;
}

function renderError() {
  const hero = document.getElementById("post-hero");
  if (hero) {
    hero.innerHTML = `
      <div class="absolute inset-0 bg-gray-800 flex items-center justify-center">
        <div class="text-center text-white px-4">
          <h1 class="text-3xl font-extrabold mb-2">Post não encontrado</h1>
          <p class="text-gray-300">O artigo que você procura não existe ou foi removido.</p>
        </div>
      </div>
    `;
  }

  const content = document.getElementById("post-content");
  if (content) {
    content.innerHTML = "";
  }

  document.title = "Post não encontrado — BGBH";
}

async function loadPost() {
  // Extrai slug da URL: /posts/boas-vindas → boas-vindas
  const path = window.location.pathname.replace(/\/$/, "");
  const slug = path.split("/").pop();

  if (!slug || slug === "posts" || slug === "post") {
    renderError();
    return;
  }

  try {
    const response = await fetch(`/api/posts.php?slug=${encodeURIComponent(slug)}`);

    if (!response.ok) {
      renderError();
      return;
    }

    const post = await response.json();

    if (post.error) {
      renderError();
      return;
    }

    renderPost(post);
  } catch (error) {
    console.error("Erro ao carregar post:", error);
    renderError();
  }
}

document.addEventListener("DOMContentLoaded", loadPost);
