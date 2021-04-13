<?php
include '../utils/functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the contact ID exists
if (isset($_GET['id'])) {
    $orderBy = $_GET['sort'];
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
            if ($orderBy)
                header('Location: painel-adm.php?sort=' . $orderBy . '');
            else
                header('Location: painel-adm.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>