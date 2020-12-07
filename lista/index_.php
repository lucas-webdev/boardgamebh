<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 200;

// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM boardgames ORDER BY name LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page - 1) * $records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$boardgames = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of boardgames, this is so we can determine whether there should be a next and previous button
$num_boardgames = $pdo->query('SELECT COUNT(*) FROM boardgames')->fetchColumn();
$num_history = $pdo->query('SELECT COUNT(*) FROM boardgames_bkp')->fetchColumn();
?>

<?= template_header('Lista de jogos') ?>
<div class="col-lg-12 margin-tb mb-3">
    <div class="sheet-title">
        <h2>LISTA DE TROCAS & VENDAS - BGBH</h2>
    </div>
    <div class="not-responsible">
        <h6>Nenhuma venda ou troca utilizando a lista de trocas & vendas é de responsabilidade da Boardgame BH</h6>
        <p class="regras-planilha">
            <i class="far fa-file-alt"></i>
            Confira as
            <a href="/lista/regras-utilizacao-lista.html" target="_blank">
                regras de utilização
            </a>
            da lista de trocas & vendas
        </p>
    </div>
    <div class="action-buttons d-flex justify-content-between">
        <div class="d-flex buttons">
            <a class="btn btn-success btn-sm" href="adicionar-jogo.php" title="Adicionar jogo">
                <i class="fas fa-plus-circle"></i>
                Adicionar jogo
            </a>
            <a class="btn btn-danger btn-sm" href="remover-jogo.php" title="Remover jogo">
                <i class="fas fa-minus-circle"></i>
                Remover jogo
            </a>
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
    <div class="num-bg">
        <h6 style="margin-bottom: 5px">Total de jogos cadastrados: <?= $num_history ?></h6>
        <h6 style="margin-bottom: 5px">Total de jogos disponíveis no momento: <?= $num_boardgames ?></h6>
    </div>
</div>
<div class="d-flex flex-column bd-highlight mb-3 bg-list" style="flex: 1">
    <div class="bg-table-header d-inline-flex justify-content-start align-items-center">
        <div class="headers" style="flex: 1.5">Jogo</div>
        <div class="headers" style="flex: 1.5">Negociação</div>
        <div class="headers" style="flex: 1">Preço</div>
        <div class="headers d-none d-lg-block" style="flex: 1">Condição</div>
        <div class="headers" style="flex: 1"></div>
    </div>
    <?php foreach ($boardgames as $bg) : ?>
        <?php
        $addedClass = '';
        $conditionClass = '';
        $diffDays = diffDaysFromToday($bg['created_at']);
        if ($diffDays == 0)
            $addedClass = 'added-today';
        if ($diffDays >= 1 && $diffDays <= 2)
            $addedClass = 'added-more-recently';
        if ($diffDays >= 3 && $diffDays <= 4)
            $addedClass = 'added-recently';
        if ($diffDays >= 60)
            $addedClass = 'added-longtime';
        if ($bg['condition'] === "Lacrado")
            $conditionClass = 'lacrado';
        if ($bg['condition'] === "Avariado")
            $conditionClass = 'avariado';
        $descricao = htmlspecialchars($bg['description']);
        ?>
        <div class="d-inline-flex justify-content-start align-items-center bg-item <?= $addedClass ?>">
            <div class="bg-fields" style="flex: 1.5"><b><?= ucwords($bg['name']) ?></b></div>
            <div class="bg-fields" style="flex: 1.5"><?= $bg['negociation'] ?></div>
            <div class="bg-fields" style="flex: 1"><?= $bg['price'] ?></div>
            <div class="bg-fields d-none d-lg-block" style="flex: 1"><?= $bg['condition'] ?></div>
            <div class="bg-fields" style="flex: 1" class="d-flex justify-content-center align-items-center">
                <button type="button" class="btn btn-sm btn-info" data-toggle="popover" data-placement="left" data-trigger="focus" title="<?= $bg['name'] ?>" data-html="true" 
                data-content="<b>Negociação:</b> <?= $bg['negociation'] ?> <br>
                        <b>Preço:</b> <?= $bg['price'] ?> <br>
                        <b>Condição:</b> <span class='<?= $conditionClass ?>'><?= $bg['condition'] ?> </span><br>
                        <b>Editora:</b> <?= ucwords($bg['edition']) ?> <br>
                        <b>Idioma:</b> <?= ucwords($bg['language']) ?> <br>
                        <b>Depend. Idioma:</b> <?= $bg['language_dependency'] ?> <br>
                        <b>Descrição:</b> <?= $descricao ?> <br>
                        <b>Responsável:</b> <?= ucwords($bg['owner']) ?> <br>
                        <b>Contato:</b> <a target='_blank' href='https://wa.me/<?= formatCellphone($bg['owner_contact']) ?>/'><?= $bg['owner_contact'] ?></a><br>
                        <b>Região de retirada/entrega:</b> <?= $bg['deliver_region'] ?> <br>
                        <b>Lista de desejos:</b> <?= printWishlist($bg['wishlist']) ?><br>"
                >
                    + info
                </button>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div class="pagination">
    <?php if ($page > 1) : ?>
        <a href="read.php?page=<?= $page - 1 ?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
    <?php endif; ?>
    <?php if ($page * $records_per_page < $num_boardgames) : ?>
        <a href="read.php?page=<?= $page + 1 ?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
    <?php endif; ?>
</div>

<?= template_footer() ?>