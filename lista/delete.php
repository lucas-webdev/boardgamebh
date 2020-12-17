<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the contact ID exists
if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM boardgames WHERE id = ?');
    $stmt->bindValue(1, $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    $boardgame = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$boardgame) {
        exit('Não existe boardgame com esse ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM boardgames WHERE id = ?');
            $stmt->bindValue(1, $_GET['id'], PDO::PARAM_INT);
            $stmt->execute();
            $msg = 'Boardgame removido com sucesso!';
            sleep(5);
            header("Location: http://www.bgbh.com.br/lista/lista-admin.php");
            exit;
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: lista-admin.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>

<?= template_header('Remover jogo') ?>

<div class="content delete">
    <h2>Remover Boardgame #<?= $boardgame['id'] . " - " . $boardgame['name'] ?></h2>
    <?php if ($msg) : ?>
        <p><?= $msg ?></p>
    <?php else : ?>
        <p>Tem certeza que deseja remover o boardgame #<?= $boardgame['id'] ?>?</p>
        <div class="yesno">
            <a class="confirm-delete" href="delete.php?id=<?= $boardgame['id'] ?>&confirm=yes">Sim</a>
            <a class="cancel-delete" href="delete.php?id=<?= $boardgame['id'] ?>&confirm=no">Não</a>
        </div>
    <?php endif; ?>
</div>

<?= template_footer() ?>