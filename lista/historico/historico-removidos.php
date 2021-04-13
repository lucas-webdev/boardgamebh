<?php
include '../utils/functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 200;

// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM removedGames WHERE reason <> "Desistência" ORDER BY name LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page - 1) * $records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$boardgames = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?= template_header('Histórico de negociações') ?>
<div class="games-to-remove">
    <h5> Histórico de negociações </h5>
    <h6> Total de jogos negociados: <?= count($boardgames) ?></h6>
    <div class="d-flex flex-column bd-highlight mb-3 bg-list" style="flex: 1">
        <div class="bg-table-header d-inline-flex justify-content-start align-items-center">
            <div class="text-center" style="flex: 3">Jogo</div>
            <div class="text-center" style="flex: 3">Responsável</div>
            <div class="text-center d-none d-lg-block" style="flex: 3">Motivo</div>
            <div class="text-center" style="flex: 3">Condição</div>
            <div class="text-center" style="flex: 3">Preço da venda</div>
        </div>
        <?php foreach ($boardgames as $bg) : ?>
            <div class="d-inline-flex justify-content-start align-items-center bg-item">
                <div class="text-center" style="flex: 3"><b><?= ucwords($bg['name']) ?></b></div>
                <div class="text-center" style="flex: 3"><?= $bg['owner'] ?></div>
                <div class="text-center d-none d-lg-block" style="flex: 3"><?= $bg['reason'] ?></div>
                <div class="text-center" style="flex: 3"><?= $bg['condition'] ?></div>
                <div class="text-center" style="flex: 3"><?= $bg['value'] ?></div>
            </div>
        <?php endforeach; ?>
    </div>
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