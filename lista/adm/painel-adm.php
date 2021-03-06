<?php
// Your PHP code here.
include '../utils/functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 200;

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
$num_boardgames = count($boardgames);
$num_history = $pdo->query('SELECT COUNT(*) FROM boardgames_bkp')->fetchColumn();
$pages = ceil($num_boardgames / $records_per_page);

$stmt3 = $pdo->prepare('SELECT * FROM gamesToRemove ORDER BY id');
$stmt3->execute();
$removedGames = $stmt3->fetchAll(PDO::FETCH_ASSOC);


$today = strtotime(date("Y-m-d"));

// Home Page template below.
?>

<?= template_header('Admin') ?>
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
<div class="dropdown mb-2">
    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
        Ordenar por
    </a>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        <li><a class="dropdown-item" href="painel-adm.php?sort=name">Nome do jogo</a></li>
        <li><a class="dropdown-item" href="painel-adm.php?sort=owner">Responsável</a></li>
        <li><a class="dropdown-item" href="painel-adm.php?sort=created_at">Data</a></li>
        <li><a class="dropdown-item" href="painel-adm.php?sort=price">Preço</a></li>
        <li><a class="dropdown-item" href="painel-adm.php?sort=condition">Condição do jogo</a></li>
        <li><a class="dropdown-item" href="painel-adm.php?sort=negociation">Tipo de negociação</a></li>
    </ul>
</div>

<div class="d-flex flex-column bd-highlight mb-3 bg-list" style="flex: 1">
    <div class="bg-table-header d-inline-flex justify-content-start align-items-center">
        <div class="headers" style="flex: 1">Jogo</div>
        <div class="headers text-center" style="flex: 1">Negociação</div>
        <div class="headers text-center" style="flex: 0.5">Preço</div>
        <div class="headers text-center" style="flex: 1">Responsável</div>
        <div class="headers text-center d-none d-lg-block" style="flex: 0.5">Última atualização</div>
        <div class="headers" style="flex: 0.5"></div>
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
            $addedClass = 'added-extra-longtime';
        if ($bg['condition'] === "Lacrado")
            $conditionClass = 'lacrado';
        if ($bg['condition'] === "Avariado")
            $conditionClass = 'avariado';
        $descricao = htmlspecialchars($bg['description']);
        ?>
        <div class="d-inline-flex justify-content-start align-items-center bg-item <?= $bg['updated_at'] ?> <?= $addedClass ?>">
            <div class="bg-fields" style="flex: 1"><b><?= ucwords($bg['name']) ?></b></div>
            <div class="bg-fields text-center" style="flex: 1"><?= $bg['negociation'] ?></div>
            <div class="bg-fields text-center" style="flex: 0.5">R$ <?= number_format($bg['price'], 2, ",", ".") ?></div>
            <div class="bg-fields text-center" style="flex: 1">
                <?= ucwords($bg['owner']) ?>
                <br />
                <a target='_blank' href='https://wa.me/<?= formatCellphone($bg['owner_contact']) ?>/'>
                    <?= $bg['owner_contact'] ?>
                </a>
            </div>
            <div class="bg-fields text-center d-none d-lg-block" style="flex: 0.5"><?= date_create_from_format('Y-m-d H:i:s', $dateToCompare)->format('d/m/y') ?></div>
            <div class="bg-fields d-flex align-items-center" style="flex: 0.5" class="d-flex justify-content-center align-items-center">
                <a tabindex="0" role="button" type="button" class="btn btn-sm primaryButton me-1 has-popover" data-bs-toggle="popover" data-bs-placement="left" data-bs-trigger="focus" title="<?= $bg['name'] ?>" data-bs-html="true" data-bs-content="<b>Negociação:</b> <?= $bg['negociation'] ?> <br>
                        <b>Preço:</b> <?= number_format($bg['price'], 2, ",", ".") ?> <br>
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

                <a href="update.php?sort=<?= $orderBy ?>&id=<?= $bg['id'] ?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                <a tabindex="0" role="button" class="trash has-popover" data-bs-toggle="popover" title="Tem certeza que deseja remover este jogo?" data-bs-content='
                        <a style="color: white; background-color: #0b655e padding: 6px;" class="confirm-delete" href="delete.php?sort=<?= $orderBy ?>&id=<?= $bg['id'] ?>&confirm=yes">Sim</a>
                        <a style="color: white; backgorund-color: #dc3545; padding: 6px;" class="cancel-delete" href="delete.php?sort=<?= $orderBy ?>&id=<?= $bg['id'] ?>&confirm=no">Não</a>
                    '>
                    <i class="fas fa-trash fa-xs"></i>
                </a>

                <form action="update.php?sort=<?= $orderBy ?>&id=<?= $bg['id'] ?>" method="POST">
                    <a href="refresh.php?sort=<?= $orderBy ?>&id=<?= $bg['id'] ?>" class="refresh"><i class="fas fa-sync fa-xs"></i></a>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<ul class="pagination d-flex justify-content-center align-items-center">
    <?php if ($page > 1) : ?>
        <li class='page-item'><a class="page-link mr-2" href="painel-adm.php?page=<?= $page - 1 ?>">
                <i class="fas fa-angle-double-left fa-sm"></i>
                Anterior
            </a>
        <?php endif; ?>
        <?php
        for ($x = 1; $x <= $pages; $x++) {
            if ($x == $page)
                echo "<li class='page-item active'><a class='page-link mr-1' href='painel-adm.php?page=$x'>$x</a>";
            else
                echo "<li class='page-item'><a class='page-link mr-1' href='painel-adm.php?page=$x'>$x</a>";
        };
        ?>
        <?php if ($page * $records_per_page < $num_boardgames) : ?>
        <li class='page-item'><a class="page-link mr-2" href="painel-adm.php?page=<?= $page + 1 ?>">
                Próxima
                <i class="fas fa-angle-double-right fa-sm"></i>
            </a>
        <?php endif; ?>
</ul>

<div class="games-to-remove" style="margin-top: 45px">
    <h5> Jogos a serem removidos </h5>
    <div class="d-flex flex-column bd-highlight mb-3 bg-list" style="flex: 1">
        <div class="bg-table-header d-inline-flex justify-content-start align-items-center">
            <div style="flex: 4">JOGO</div>
            <div style="flex: 3">RESPONSÁVEL</div>
            <div style="flex: 4">MOTIVO</div>
            <div style="flex: 1">AÇÕES</div>
        </div>
        <?php foreach ($removedGames as $bg) : ?>
            <div class="d-inline-flex justify-content-start align-items-center bg-item">
                <div style="flex: 4"><b><?= ucwords($bg['name']) ?></b></div>
                <div style="flex: 3"><?= $bg['owner'] ?></div>
                <div style="flex: 4"><?= $bg['reason'] ?></div>
                <div style="flex: 1">
                    <a class="has-popover trash" tabindex="0" role="button" data-bs-toggle="popover" data-bs-trigger="click" data-bs-html="true" title="Tem certeza que deseja remover este jogo?" data-bs-content='
                            <a class="confirm-delete" href="delete_removed.php?id=<?= $bg['id'] ?>&confirm=yes" style="color: white; background-color: #0b655e padding: 6px;">Sim</a>
                            <a class="cancel-delete">Não</a>'>
                        <i class="fas fa-trash fa-xs"></i>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?= template_footer() ?>