<?php

/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/pt-br:Editando_wp-config.php
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações
// com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'lucascmedeiros_com_br2');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'lucascmedeir2');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', 'l9T?e8');

/** Nome do host do MySQL */
define('DB_HOST', 'mysql.lucascmedeiros.com.br');

/** Charset do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8mb4');

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '1K,dZeBe.GiZS (R.q%G^ul8<CK^=Es!<zc:!6gt#0BTjd1HsB}t-G cIJx^@p$h7');
define('SECURE_AUTH_KEY',  '}ulUDru7zwbYeS=4!jC8{78;{tsmg,Fq!?b2-MAMsYL|Hw3B;eeoC6*B`Zs[{7[zt');
define('LOGGED_IN_KEY',    'W.3~3Br3Ub}_w%(Q>.k:KOh;I4tO-dd`b<dr*<xWU=9r~AzRybm ~yDsrW,n6f**x');
define('NONCE_KEY',        '4y$gh)I/19E0/cC/TY`KwR2.CN0v0rYUEJ Db`2=/PhM(O/~GCxFaTy0{KVaJ):OI');
define('AUTH_SALT',        'Q#Or+}Rrg<iaet7HVT1H#DO[oIXvUhZ]@cTV]Gpo2(^CH;g99&ft|0ua=B8lV;r=<');
define('SECURE_AUTH_SALT', ')&~[V1VB_IBsT7Eps1Zn{MoXd9)44rmlirXZzUjb>/]yQ[<{Bq*Oy_5mxnb&/atk{');
define('LOGGED_IN_SALT',   '|Em>1#Jpz~*Ywmb9TiW805?r_5!P rb&~o4P,_}=TvDb|`PuyC!w&]xATn)iE?mc&');
define('NONCE_SALT',       'WOg}/(FDv{i<7GyT([&AdE38[x|L{N`=2NXzggBSf%-md}HNBqCnf4@N%&OnFBy=@');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wptask_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://codex.wordpress.org/pt-br:Depura%C3%A7%C3%A3o_no_WordPress
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if (!defined('ABSPATH'))
	define('ABSPATH', dirname(__FILE__) . '/');

/** Configura as variáveis e arquivos do WordPress. */
require_once(ABSPATH . 'wp-settings.php');
