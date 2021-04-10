<?php
// Your PHP code here.
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 100;
$sql = "SELECT * FROM boardgames WHERE DATE(created_at) > (NOW() - INTERVAL 7 DAY) ORDER BY name LIMIT :current_page, :record_per_page";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':current_page', ($page - 1) * $records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$boardgames = $stmt->fetchAll(PDO::FETCH_ASSOC);
$pages = ceil(count($boardgames) / $records_per_page);


$today = strtotime(date("Y-m-d"));

// Home Page template below.
?>

<?= template_header('Admin') ?>
<h6>Total de jogos: <?= count($boardgames) ?></h6>
<div class="d-flex flex-column bd-highlight mb-3 bg-list" style="flex: 1">
    <div class="bg-table-header d-inline-flex justify-content-start align-items-center">
        <div class="headers" style="flex: 1.5">Jogo</div>
    </div>
    <?php foreach ($boardgames as $bg) : ?>
        <?php
        $addedClass = '';
        $conditionClass = '';
        $diffDays = diffDaysFromToday($bg['created_at']);
        if ($diffDays >= 0 && $diffDays <= 7)
            $addedClass = 'added-recently';
        ?>
        <div class="d-inline-flex justify-content-start align-items-center bg-item <?= $addedClass ?>">
            <div class="bg-fields" style="flex: 1.5"><b><?= ucwords($bg['name']) ?></b></div>
        </div>
    <?php endforeach; ?>
</div>
<ul class="pagination d-flex justify-content-center align-items-center">
    <?php if ($page > 1) : ?>
        <li class='page-item'><a class="page-link mr-2" href="historico-7-dias.php?page=<?= $page - 1 ?>">
                <i class="fas fa-angle-double-left fa-sm"></i>
                Anterior
            </a>
        <?php endif; ?>
        <?php
        for ($x = 1; $x <= $pages; $x++) {
            if ($x == $page)
                echo "<li class='page-item active'><a class='page-link mr-1' href='historico-7-dias.php?page=$x'>$x</a>";
            else
                echo "<li class='page-item'><a class='page-link mr-1' href='historico-7-dias.php?page=$x'>$x</a>";
        };
        ?>
        <?php if ($page * $records_per_page < count($boardgames)) : ?>
        <li class='page-item'><a class="page-link mr-2" href="historico-7-dias.php?page=<?= $page + 1 ?>">
                Próxima
                <i class="fas fa-angle-double-right fa-sm"></i>
            </a>
        <?php endif; ?>
</ul>

<?= template_footer() ?>