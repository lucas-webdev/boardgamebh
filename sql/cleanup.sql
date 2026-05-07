-- =============================================================
-- cleanup.sql
-- Remove tabelas WordPress e cria a tabela posts com seed data
-- =============================================================
SET FOREIGN_KEY_CHECKS = 0;
-- Drop WordPress tables (prefixo wptask_)
DROP TABLE IF EXISTS wptask_commentmeta,
wptask_comments,
wptask_links,
wptask_options,
wptask_postmeta,
wptask_posts,
wptask_term_relationships,
wptask_term_taxonomy,
wptask_termmeta,
wptask_terms,
wptask_usermeta,
wptask_actionscheduler_actions wptask_actionscheduler_claims,
wptask_actionscheduler_groups,
wptask_actionscheduler_logs,
wptask_e_events,
wptask_pieregister_code,
wptask_pieregister_custom_user_roles,
wptask_pieregister_invite_code_emails,
wptask_pieregister_lockdowns,
wptask_pieregister_redirect_settings,
wptask_rtec_registrations,
wptask_tec_events,
wptask_tec_occurrences,
wptask_um_metadata,
wptask_user_registration_sessions,
wptask_uwp_form_extras,
wptask_uwp_form_fields,
wptask_uwp_profile_tabs,
wptask_uwp_usermeta,
wptask_uwp_user_sorting,
wptask_users;
SET FOREIGN_KEY_CHECKS = 1;
-- =============================================================
-- Tabela posts
-- =============================================================
CREATE TABLE IF NOT EXISTS posts (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(255) NOT NULL UNIQUE,
  title VARCHAR(500) NOT NULL,
  date DATE NOT NULL,
  author VARCHAR(100) NOT NULL DEFAULT 'Lucas',
  summary TEXT NOT NULL,
  image VARCHAR(500) NOT NULL,
  tags JSON NOT NULL,
  content LONGTEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY idx_date (date DESC)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_520_ci;
-- =============================================================
-- Seed: 3 posts existentes
-- =============================================================
INSERT INTO posts (
    slug,
    title,
    date,
    author,
    summary,
    image,
    tags,
    content
  )
VALUES (
    'boas-vindas-ao-novo-portal',
    'Bem-vindos ao novo portal BoardgameBH!',
    '2025-07-15',
    'Lucas',
    'O BoardgameBH está de cara nova! Conheça o novo portal, as funcionalidades que estão chegando e como acompanhar tudo sobre o mundo dos jogos de tabuleiro em BH.',
    '/img/geral/bgbh-topo-site.jpg',
    '["novidades", "portal"]',
    '<p class="text-lg">
  Depois de meses de trabalho, estamos felizes em apresentar o novo portal do <strong>BoardgameBH</strong>!
  O site foi completamente repensado para ser mais dinâmico, organizado e informativo.
</p>

<h2 class="text-2xl font-bold text-gray-800 mt-8 mb-3">O que mudou?</h2>

<p>
  O portal agora funciona como um hub central para todas as nossas iniciativas. Na página inicial
  você encontra os artigos mais recentes, acesso rápido à Math Trade BH, nossas iniciativas, grupos
  de WhatsApp e parcerias — tudo organizado em uma interface limpa e moderna.
</p>

<h2 class="text-2xl font-bold text-gray-800 mt-8 mb-3">Artigos e notícias</h2>

<p>
  Uma das grandes novidades é a seção de artigos. Agora a equipe do BGBH vai publicar regularmente:
</p>

<ul class="list-disc pl-6 space-y-1">
  <li>Novidades sobre nossas iniciativas e eventos</li>
  <li>Reviews e opiniões sobre jogos de tabuleiro</li>
  <li>Dicas para quem está começando no hobby</li>
  <li>Cobertura de eventos como o Nerd Experience</li>
</ul>

<h2 class="text-2xl font-bold text-gray-800 mt-8 mb-3">O que vem por aí</h2>

<p>
  Estamos planejando muitas novidades para os próximos meses. A 10ª edição da Math Trade BH
  está chegando em setembro, o BGBH Masters continua com torneios online no Board Game Arena,
  e temos novos eventos presenciais no radar.
</p>

<p>
  Fique ligado nas nossas redes sociais e no portal para não perder nenhuma novidade.
  <strong>Let''s Play!</strong>
</p>'
  ),
  (
    'math-trade-10-edicao',
    '10ª Edição da Math Trade BH — Setembro 2025',
    '2025-07-10',
    'Lucas',
    'A décima edição da Math Trade Belo Horizonte está chegando! Confira as datas, regras e como participar dessa que é uma das maiores Math Trades do Brasil.',
    '/img/mathtrade/615x330-MT10.png',
    '["math-trade", "eventos"]',
    '<p class="text-lg">
  A <strong>10ª edição da Math Trade Belo Horizonte</strong> está chegando! Essa é uma das maiores
  Math Trades do Brasil e uma excelente oportunidade para renovar sua coleção de jogos de tabuleiro.
</p>

<h2 class="text-2xl font-bold text-gray-800 mt-8 mb-3">O que é uma Math Trade?</h2>

<p>
  Uma Math Trade é um sistema de trocas coletivas onde um algoritmo encontra as melhores combinações
  de trocas entre os participantes. Você cadastra os jogos que quer trocar, define quais jogos
  aceita em troca e o sistema resolve tudo automaticamente.
</p>

<h2 class="text-2xl font-bold text-gray-800 mt-8 mb-3">Datas importantes</h2>

<ul class="list-disc pl-6 space-y-1">
  <li><strong>Cadastro de jogos:</strong> a ser definido</li>
  <li><strong>Definição de wishlists:</strong> a ser definido</li>
  <li><strong>Execução do algoritmo:</strong> a ser definido</li>
  <li><strong>Prazo de entrega:</strong> 04 de outubro de 2025</li>
</ul>

<h2 class="text-2xl font-bold text-gray-800 mt-8 mb-3">Como participar?</h2>

<p>
  Para participar, acesse a
  <a href="/mathtrade-bh/edicao-setembro-2025" class="text-green-700 underline hover:text-green-800">
    página da edição atual
  </a>
  e confira todas as regras e o cronograma. Se é sua primeira vez, recomendamos ler
  <a href="/mathtrade-bh/o-que-e" class="text-green-700 underline hover:text-green-800">
    o que é uma Math Trade
  </a>
  e a página de
  <a href="/mathtrade-bh/faq" class="text-green-700 underline hover:text-green-800">
    perguntas frequentes
  </a>.
</p>

<p>
  Não perca essa chance de renovar sua coleção! <strong>Let''s Play!</strong>
</p>'
  ),
  (
    'bgbh-masters-temporada-1',
    'BGBH Masters — Primeira Temporada de Torneios Online',
    '2025-06-20',
    'Lucas',
    'Lançamos o BGBH Masters, uma série de torneios online disputados no Board Game Arena. Saiba como participar e disputar a primeira temporada.',
    '/img/geral/brass.png',
    '["torneios", "bgbh-masters"]',
    '<p class="text-lg">
  Lançamos o <strong>BGBH Masters</strong>, uma série de torneios online disputados no
  <a href="https://boardgamearena.com/lobby" target="_blank"
    class="text-green-700 underline hover:text-green-800">Board Game Arena (BGA)</a>.
  A primeira temporada já está em andamento!
</p>

<h2 class="text-2xl font-bold text-gray-800 mt-8 mb-3">Como funciona?</h2>

<p>
  O BGBH Masters consiste em temporadas de torneios online. Cada temporada traz vários jogos
  diferentes e os torneios são disputados em modo por turnos, permitindo que você jogue no
  seu próprio ritmo.
</p>

<h2 class="text-2xl font-bold text-gray-800 mt-8 mb-3">Como participar?</h2>

<p>Para participar é preciso:</p>

<ul class="list-disc pl-6 space-y-1">
  <li>Ter conta no Board Game Arena</li>
  <li>Conhecer as regras da competição</li>
  <li>Se inscrever nos torneios de interesse quando disponibilizados</li>
</ul>

<p>
  Todas as regras e detalhes da competição estão na
  <a href="/bgbh-masters/" class="text-green-700 underline hover:text-green-800">
    página do BGBH Masters
  </a>.
</p>

<h2 class="text-2xl font-bold text-gray-800 mt-8 mb-3">Temporada 2 chegando!</h2>

<p>
  A planilha de pré-inscrição para a Temporada 2 já está disponível. Não perca a chance de
  participar e mostrar suas habilidades nos jogos de tabuleiro.
</p>

<p>
  Nos vemos no BGA! <strong>Let''s Play!</strong>
</p>'
  );