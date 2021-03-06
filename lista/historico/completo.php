<?php
include '../utils/functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 200;

// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM boardgames_bkp ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page - 1) * $records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$boardgames = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of boardgames, this is so we can determine whether there should be a next and previous button
$num_boardgames = $pdo->query('SELECT COUNT(*) FROM boardgames')->fetchColumn();
?>

<?= template_header('Histórico Completo') ?>
<div class="row">
    <div class="col-lg-12 margin-tb mb-3">
        <div class="pull-left">
            <h2>PLANILHA DE TROCA E VENDA - BGBH - HISTÓRICO</h2>
        </div>
    </div>
    <div class="col-12">
        <h6 style="margin-bottom: 8px">Total de jogos já cadastrados: <?= $num_boardgames ?></h6>
    </div>
    <div class="d-flex flex-column bd-highlight mb-3 bg-list" style="flex: 1">
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
            <div class="d-inline-flex justify-content-start align-items-center bg-item <?= $$bg['created_at'] ?> <?= $addedClass ?>">
                <div class="bg-fields" style="flex: 1.5"><b><?= ucwords($bg['name']) ?></b></div>
                <div class="bg-fields text-center" style="flex: 1.2"><?= $bg['negociation'] ?></div>
                <div class="bg-fields text-center" style="flex: 1"><?= $bg['price'] ?></div>
                <div class="bg-fields text-center d-none d-lg-block <?= $conditionClass ?>" style="flex: 1"><?= $bg['condition'] ?></div>
                <div class="bg-fields has-popover" style="flex: 1" class="d-flex justify-content-center align-items-center">
                    <button type="button" class="btn btn-sm btn-info" data-toggle="popover" data-placement="left" data-trigger="focus" title="<?= $bg['name'] ?>" data-html="true" data-content="<b>Negociação:</b> <?= $bg['negociation'] ?> <br>
                        <b>Preço:</b> <?= $bg['price'] ?> <br>
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
</div>

<?= template_footer() ?>