/**
 * Footer compartilhado — injeta footer em #footer-root
 * Importar em cada página: <script type="module" src="/src/js/footer.js"></script>
 */

function renderFooter() {
  const root = document.getElementById("footer-root");
  if (!root) return;

  const currentYear = new Date().getFullYear();

  root.innerHTML = `
    <footer class="bg-gray-800 bottom-0 relative w-full">
      <div class="px-4 py-8 max-w-[1080px] mx-auto grid md:grid-flow-col md:grid-cols-2 text-gray-300 gap-6">
        <div>
          <strong class="font-bold block mb-3 text-white">SOBRE O PROJETO</strong>
          <span class="text-sm leading-relaxed">
            O <strong class="font-semibold text-white">BoardgameBH</strong> é um projeto que tem como foco o
            crescimento e a visibilidade do Boardgame no país. O portal tem Belo Horizonte e região como carro chefe,
            mas não possui fronteiras, promovendo e realizando ações de amplo interesse e com um público espalhado
            por todo país, como torneios online, divulgação de lançamentos e conteúdo digital. Diversos braços do
            projeto ainda estão em desenvolvimento e em breve serão apresentados para o grande público. Enquanto isso,
            aproveite todas as funcionalidades liberadas e não deixe de apoiar esse e os demais projetos voltados para
            o nosso hobby.
            <strong class="font-semibold text-white">Let's Play!</strong>
          </span>
        </div>
        <div class="flex flex-col justify-between">
          <div>
            <strong class="block mb-3 text-white">APOIE</strong>
            <span class="text-sm">Entre em contato para ser um parceiro ou apoiador do projeto!</span>
          </div>
          <div>
            <div class="font-bold mt-4 mb-3 text-white">SIGA</div>
            <ul class="flex gap-4">
              <li>
                <a target="_blank" href="https://www.instagram.com/boardgamebh/" aria-label="Instagram">
                  <i class="bi bi-instagram text-[24px] block hover:scale-125 transition-transform"></i>
                </a>
              </li>
              <li>
                <a target="_blank" href="https://www.facebook.com/boardgamebh/" aria-label="Facebook">
                  <i class="bi bi-facebook text-[24px] block hover:scale-125 transition-transform"></i>
                </a>
              </li>
            </ul>
          </div>
          <div class="mt-4 font-semibold text-sm text-gray-400">
            &copy; BGBH 2020-${currentYear} - Todos os direitos reservados
          </div>
        </div>
      </div>
    </footer>
  `;
}

document.addEventListener("DOMContentLoaded", renderFooter);
