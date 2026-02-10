/**
 * Sistema de posts — renderiza cards de artigos a partir de posts.json
 *
 * Uso na homepage:
 *   <div id="post-destaque"></div>
 *   <div id="posts-grid"></div>
 *
 * Uso na página de listagem (/posts/index.html):
 *   <div id="posts-all"></div>
 *
 * Uso na sidebar:
 *   <div id="posts-sidebar"></div>
 */

async function loadPosts() {
  try {
    const response = await fetch("/posts/posts.json");
    const posts = await response.json();
    // Ordena por data, mais recente primeiro
    return posts.sort((a, b) => new Date(b.date) - new Date(a.date));
  } catch (error) {
    console.error("Erro ao carregar posts:", error);
    return [];
  }
}

function formatDate(dateStr) {
  const date = new Date(dateStr + "T00:00:00");
  return date.toLocaleDateString("pt-BR", {
    day: "2-digit",
    month: "long",
    year: "numeric",
  });
}

function renderTagChips(tags) {
  return tags
    .map(
      (tag) =>
        `<span class="inline-block bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded">${tag}</span>`
    )
    .join(" ");
}

/** Card destaque — post principal na homepage */
function renderFeaturedPost(post) {
  return `
    <a href="/posts/${post.slug}.html" class="block group">
      <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
        <div class="aspect-video overflow-hidden">
          <img src="${post.image}" alt="${post.title}"
               class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        </div>
        <div class="p-5">
          <div class="flex items-center gap-3 text-sm text-gray-500 mb-2">
            <span>${formatDate(post.date)}</span>
            <span>•</span>
            <span>${post.author}</span>
          </div>
          <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-2 group-hover:text-green-700 transition-colors">
            ${post.title}
          </h2>
          <p class="text-gray-600 leading-relaxed">${post.summary}</p>
          <div class="mt-3 flex gap-2">${renderTagChips(post.tags)}</div>
        </div>
      </article>
    </a>
  `;
}

/** Card menor — posts secundários na homepage */
function renderPostCard(post) {
  return `
    <a href="/posts/${post.slug}.html" class="block group">
      <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow h-full">
        <div class="aspect-video overflow-hidden">
          <img src="${post.image}" alt="${post.title}"
               class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        </div>
        <div class="p-4">
          <div class="text-xs text-gray-500 mb-1">
            ${formatDate(post.date)} • ${post.author}
          </div>
          <h3 class="font-bold text-gray-800 mb-1 group-hover:text-green-700 transition-colors line-clamp-2">
            ${post.title}
          </h3>
          <p class="text-sm text-gray-600 line-clamp-2">${post.summary}</p>
          <div class="mt-2 flex gap-1 flex-wrap">${renderTagChips(post.tags)}</div>
        </div>
      </article>
    </a>
  `;
}

/** Lista compacta para sidebar */
function renderSidebarPost(post) {
  return `
    <a href="/posts/${post.slug}.html" class="block hover:text-green-700 transition-colors">
      <div class="py-2 border-b border-gray-100 last:border-0">
        <p class="font-medium text-sm text-gray-800 leading-tight">${post.title}</p>
        <span class="text-xs text-gray-500">${formatDate(post.date)}</span>
      </div>
    </a>
  `;
}

/** Renderiza homepage: post destaque + grid */
async function renderHomepagePosts() {
  const posts = await loadPosts();
  if (posts.length === 0) return;

  // Post destaque
  const featuredEl = document.getElementById("post-destaque");
  if (featuredEl) {
    featuredEl.innerHTML = renderFeaturedPost(posts[0]);
  }

  // Grid de posts (próximos 4)
  const gridEl = document.getElementById("posts-grid");
  if (gridEl && posts.length > 1) {
    const gridPosts = posts.slice(1, 5);
    gridEl.innerHTML = gridPosts.map(renderPostCard).join("");
  }
}

/** Renderiza sidebar com últimos 5 posts */
async function renderSidebarPosts() {
  const posts = await loadPosts();
  const sidebarEl = document.getElementById("posts-sidebar");
  if (!sidebarEl || posts.length === 0) return;

  const latestPosts = posts.slice(0, 5);
  sidebarEl.innerHTML = latestPosts.map(renderSidebarPost).join("");
}

/** Renderiza listagem completa (página /posts/) */
async function renderAllPosts() {
  const posts = await loadPosts();
  const allEl = document.getElementById("posts-all");
  if (!allEl) return;

  if (posts.length === 0) {
    allEl.innerHTML = `<p class="text-gray-500 text-center py-8">Nenhum artigo publicado ainda.</p>`;
    return;
  }

  // Extrai todas as tags únicas
  const allTags = [...new Set(posts.flatMap((p) => p.tags))].sort();

  // Filtro por tags
  const tagFilter = `
    <div class="mb-6 flex flex-wrap gap-2" id="tag-filters">
      <button class="tag-filter-btn px-3 py-1 rounded-full text-sm font-medium bg-green-700 text-white" data-tag="all">
        Todos
      </button>
      ${allTags
        .map(
          (tag) =>
            `<button class="tag-filter-btn px-3 py-1 rounded-full text-sm font-medium bg-gray-200 text-gray-700 hover:bg-green-100" data-tag="${tag}">${tag}</button>`
        )
        .join("")}
    </div>
  `;

  const postsGrid = `
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="posts-all-grid">
      ${posts.map(renderPostCard).join("")}
    </div>
  `;

  allEl.innerHTML = tagFilter + postsGrid;

  // Tag filter logic
  document.getElementById("tag-filters").addEventListener("click", (e) => {
    const btn = e.target.closest(".tag-filter-btn");
    if (!btn) return;

    const selectedTag = btn.dataset.tag;

    // Update button styles
    document.querySelectorAll(".tag-filter-btn").forEach((b) => {
      b.classList.remove("bg-green-700", "text-white");
      b.classList.add("bg-gray-200", "text-gray-700");
    });
    btn.classList.remove("bg-gray-200", "text-gray-700");
    btn.classList.add("bg-green-700", "text-white");

    // Filter posts
    const filteredPosts =
      selectedTag === "all"
        ? posts
        : posts.filter((p) => p.tags.includes(selectedTag));

    document.getElementById("posts-all-grid").innerHTML = filteredPosts
      .map(renderPostCard)
      .join("");
  });
}

document.addEventListener("DOMContentLoaded", () => {
  renderHomepagePosts();
  renderSidebarPosts();
  renderAllPosts();
});
