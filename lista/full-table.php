<?php
// Your PHP code here.
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 200;

$stmt = $pdo->prepare('SELECT * FROM boardgames ORDER BY name LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page - 1) * $records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$boardgames = $stmt->fetchAll(PDO::FETCH_ASSOC);
$num_boardgames = $pdo->query('SELECT COUNT(*) FROM boardgames')->fetchColumn();

$today = strtotime(date("Y-m-d"));

// Home Page template below.
?>

<?= template_header('Home') ?>

<div class="row">
    <div class="col-lg-12 margin-tb mb-3">
        <div class="pull-left">
            <h2>PLANILHA DE TROCA E VENDA - BGBH</h2>
        </div>
        <div class="not-responsible">
            <h6>Nenhuma venda ou troca utilizando a planilha é de responsabilidade da Boardgame BH</h6>
        </div>
        <div class="pull-right">
            <a class="btn btn-success btn-sm" href="adicionar-jogo.php" title="Adicionar jogo">
                <i class="fas fa-plus-circle"></i>
                Adicionar jogo
            </a>
            <a class="btn btn-danger btn-sm" href="remover-jogo.php" title="Remover jogo">
                <i class="fas fa-minus-circle"></i>
                Remover jogo
            </a>
        </div>
    </div>
    <div class="col-12">
        <h6 style="margin-bottom: 8px">Total de jogos cadastrados: <?= $num_boardgames ?></h6>
    </div>
    <div class="d-flex flex-column bd-highlight mb-3 bg-list" style="flex: 1">
        <div class="bg-table-header d-inline-flex justify-content-start align-items-center">
            <div style="flex: 1.5">JOGO</div>
            <div style="flex: 1.5">NEGOCIAÇÃO</div>
            <div style="flex: 1">PREÇO</div>
            <div style="flex: 1"></div>
        </div>
        <?php foreach ($boardgames as $bg) : ?>
            <?php
            $addedClass = '';
            $conditionClass = '';
            $diffDays = diffDaysFromToday($bg['created_at']);
            if ($diffDays == 0)
                $addedClass = 'added-today';
            if ($diffDays >= 1 && $diffDays <= 3)
                $addedClass = 'added-recently';
            if ($bg['condition'] === "Lacrado")
                $conditionClass = 'lacrado';
            if ($bg['condition'] === "Avariado")
                $conditionClass = 'avariado';
            ?>
            <div class="d-inline-flex justify-content-start align-items-center bg-item <?= $addedClass ?>">
                <div style="flex: 1.5"><b><?= ucwords($bg['name']) ?></b></div>
                <div style="flex: 1.5"><?= $bg['negociation'] ?></div>
                <div style="flex: 1"><?= $bg['price'] ?></div>
                <div style="flex: 1" class="d-flex justify-content-center align-items-center">
                    <button type="button" class="btn btn-sm btn-info" data-toggle="popover" data-placement="left" data-trigger="focus" title="<?= $bg['name'] ?>" data-html="true" data-content="<b>Negociação:</b> <?= $bg['negociation'] ?> <br>
                            <b>Preço:</b> <?= $bg['price'] ?> <br>
                            <span class='<?= $conditionClass ?>'></span><b>Condição:</b> <?= $bg['condition'] ?> </span><br>
                            <b>Editora:</b> <?= ucwords($bg['edition']) ?> <br>
                            <b>Idioma:</b> <?= ucwords($bg['language']) ?> <br>
                            <b>Depend. Idioma:</b> <?= $bg['language_dependency'] ?> <br>
                            <b>Descrição:</b> <?= $bg['description'] ?> <br>
                            <b>Responsável:</b> <?= ucwords($bg['owner']) ?> <br>
                            <b>Contato:</b> <a target='_blank' href='https://wa.me/<?= formatCellphone($bg['owner_contact']) ?>/'><?= $bg['owner_contact'] ?></a><br>
                            <b>Lista de desejos:</b> <?= printWishlist($bg['wishlist']) ?><br>
                            <b>Região de retirada:</b> <?= $bg['deliver_region'] ?><br>
                            ">
                        Info completa
                    </button>
                    <a href="update.php?id=<?= $bg['id'] ?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?id=<?= $bg['id'] ?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
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
</div>

<?= template_footer() ?>