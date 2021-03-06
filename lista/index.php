<?php
include 'utils/functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 200;

// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$sql = "SELECT * FROM boardgames ";
$orderBy = $_GET['sort'];
if ($orderBy) $sql .= "ORDER BY " . $orderBy . " ";
else $sql .= "ORDER BY name ASC ";
$sql .= "LIMIT :current_page, :record_per_page";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':current_page', ($page - 1) * $records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$boardgames = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of boardgames, this is so we can determine whether there should be a next and previous button
$num_boardgames = count($boardgames);
$num_history = $pdo->query('SELECT COUNT(*) FROM boardgames_bkp')->fetchColumn();
$pages = ceil($num_boardgames / $records_per_page);
?>

<?= template_header('Lista de jogos') ?>
<div class="col-lg-12 margin-tb mb-3">
    <div class="sheet-title">
        <i class="icone bi bi-list-stars"></i>
        <h1 class="d-inline-block ms-2">LISTA DE TROCAS & VENDAS - BGBH</h1>
    </div>
    <div class="not-responsible">
        <span class="danger semibold d-block my-2">
            <i class="icone danger bi bi-exclamation-diamond me-1"></i>
            Nenhuma negociação utilizando a <span class="extrabold danger">Lista de Trocas & Vendas</span> é de responsabilidade do Boardgame BH
        </span>
        <p class="regras-planilha">
            <i class="icone bi bi-file-earmark-text me-1"></i>
            Confira as
            <a class="inheritLink" href="/regras-lista.html" target="_blank">
                regras de utilização
            </a>
            da lista de trocas & vendas
        </p>
    </div>
    <div class="action-buttons d-flex justify-content-between">

        <div class="d-flex buttons">
            <div class="botoes-lista">
                <div class="d-flex justify-content-start align-items-center">
                    <a target="_blank" href="/lista/adicionar-jogo/" class="image featured btn-planilha adicionar-jogo me-3" onclick="ga('send', 'event', 'botões lista', 'click', 'adicionar');">
                        <img class="img-fluid btnImage" src="http://www.bgbh.com.br/public/images/botoes/btn-adicionar.png" alt="Adicionar jogo" />
                        <small class="extrabold">ADICIONAR JOGO</small>
                    </a>
                    <a target="_blank" href="/lista/remover-jogo" class="image featured btn-planilha remover-jogo" onclick="ga('send', 'event', 'botões lista', 'click', 'remover');">
                        <img class="img-fluid btnImage" src="http://www.bgbh.com.br/public/images/botoes/btn-remover.png" alt="Remover jogo" />
                        <small class="extrabold">REMOVER JOGO</small>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="num-bg d-flex justify-content-lg-between mt-3">
        <div>
            <small class="mb-1">Total de jogos já cadastrados: <?= $num_history ?></small>
            <br />
            <small class="mb-1">Total de jogos disponíveis no momento: <?= $num_boardgames ?></small>
        </div>
        <div class="legenda">
            <div class="d-flex align-items-center">
                <span class="square bg-item added-today"></span>
                Jogos adicionados nas últimas 24h
            </div>
            <div class="d-flex align-items-center">
                <span class="square bg-item added-more-recently"></span>
                Jogos adicionados recentemente
            </div>
            <div class="d-flex align-items-center">
                <span class="square bg-item added-longtime"></span>
                Jogos que precisam de recadastramento
            </div>
        </div>
    </div>
</div>
<div class="dropdown">
    <a class="btn btn-secondary btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
        Ordenar por
    </a>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        <li><a class="dropdown-item" href="index.php?sort=name">Nome do jogo</a></li>
        <li><a class="dropdown-item" href="index.php?sort=owner">Responsável</a></li>
        <li><a class="dropdown-item" href="index.php?sort=updated_at">Data</a></li>
        <li><a class="dropdown-item" href="index.php?sort=price">Preço</a></li>
        <li><a class="dropdown-item" href="index.php?sort=condition">Condição do jogo</a></li>
        <li><a class="dropdown-item" href="index.php?sort=negociation">Tipo de negociação</a></li>
    </ul>
</div>
<div class="d-flex flex-column bd-highlight mt-2 mb-3 bg-list flex-1">
    <div class="bg-table-header d-inline-flex justify-content-start align-items-center">
        <div class="headers" style="flex: 1.5">Jogo</div>
        <div class="headers text-center" style="flex: 1.2">Negociação</div>
        <div class="headers text-center" style="flex: 1">Preço</div>
        <div class="headers text-center d-none d-lg-block" style="flex: 1">Condição</div>
        <div class="headers" style="flex: 1"></div>
    </div>
    <?php foreach ($boardgames as $bg) : ?>
        <?php
        $addedClass = '';
        $conditionClass = '';
        $dateToCompare = $bg['updated_at'] === NULL ? $bg['created_at'] : $bg['updated_at'];
        $diffDays = diffDaysFromToday($dateToCompare);
        if ($diffDays == 0)
            $addedClass = 'added-today';
        if ($diffDays >= 1 && $diffDays <= 2)
            $addedClass = 'added-more-recently';
        if ($diffDays >= 3 && $diffDays <= 4)
            $addedClass = 'added-recently';
        if ($diffDays >= 50 && $diffDays <= 60)
            $addedClass = 'added-longtime';
        if ($diffDays >= 61)
            $addedClass = 'added-extra-longtime d-none';
        if ($bg['condition'] === "Lacrado")
            $conditionClass = 'lacrado';
        if ($bg['condition'] === "Avariado")
            $conditionClass = 'avariado';
        $descricao = htmlspecialchars($bg['description']);
        ?>
        <div class="d-inline-flex justify-content-start align-items-center bg-item <?= $diffDays ?> <?= $addedClass ?>">
            <div class="bg-fields" style="flex: 1.5"><b><?= ucwords($bg['name']) ?></b></div>
            <div class="bg-fields text-center" style="flex: 1.2"><?= $bg['negociation'] ?></div>
            <div class="bg-fields text-center" style="flex: 1">R$ <?= number_format($bg['price'], 2, ",", ".") ?></div>
            <div class="bg-fields text-center d-none d-lg-block <?= $conditionClass ?>" style="flex: 1"><?= $bg['condition'] ?></div>
            <div class="bg-fields has-popover" style="flex: 1" class="d-flex justify-content-center align-items-center">
                <a tabindex="0" type="button" class="btn btn-sm btn-dark has-popover" role="button" data-bs-toggle="popover" data-bs-placement="left" data-bs-trigger="focus" title="<?= $bg['name'] ?>" data-bs-html="true" data-bs-html="true" data-bs-content="<b>Negociação:</b> <?= $bg['negociation'] ?> <br>
                        <b>Preço:</b> R$ <?= number_format($bg['price'], 2, ",", ".") ?> <br>
                        <b>Condição:</b> <span class='<?= $conditionClass ?>'><?= $bg['condition'] ?> </span><br>
                        <b>Editora:</b> <?= ucwords($bg['edition']) ?> <br>
                        <b>Idioma:</b> <?= ucwords($bg['language']) ?> <br>
                        <b>Depend. Idioma:</b> <?= $bg['language_dependency'] ?> <br>
                        <b>Descrição:</b> <?= $descricao ?> <br>
                        <b>Responsável:</b> <?= ucwords($bg['owner']) ?> <br>
                        <b>Contato:</b> <a target='_blank' href='https://wa.me/<?= formatCellphone($bg['owner_contact']) ?>/'><?= $bg['owner_contact'] ?></a><br>
                        <b>Região de retirada/entrega:</b> <?= $bg['deliver_region'] ?> <br>
                        <b>Lista de desejos:</b> <?= printWishlist($bg['wishlist']) ?><br>">
                    + info
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<ul class="pagination d-flex justify-content-center align-items-center">
    <?php if ($page > 1) : ?>
        <li class='page-item'><a class="page-link mr-2" href="?page=<?= $page - 1 ?>">
                <i class="fas fa-angle-double-left fa-sm"></i>
                Anterior
            </a>
        <?php endif; ?>
        <?php
        for ($x = 1; $x <= $pages; $x++) {
            if ($x == $page)
                echo "<li class='page-item active'><a class='page-link mr-1' href='?page=$x'>$x</a>";
            else
                echo "<li class='page-item'><a class='page-link mr-1' href='?page=$x'>$x</a>";
        };
        ?>
        <?php if ($page * $records_per_page < $num_boardgames) : ?>
        <li class='page-item'><a class="page-link mr-2" href="?page=<?= $page + 1 ?>">
                Próxima
                <i class="fas fa-angle-double-right fa-sm"></i>
            </a>
        <?php endif; ?>
</ul>
<style>
    #mainNavbar.navbar-dark .navbar-nav .nav-item:nth-child(2) a {
        color: white;
    }
</style>

<?= template_footer() ?>