<?php
include '../utils/functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (isset($_GET['id'])) {
    $orderBy = $_GET['sort'];
    // Insert new record into the boardgames table
    if (count($errors) === 0) {
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare('UPDATE `boardgames` SET `updated_at` = ? WHERE id = ?');
            $stmt->bindValue(1, date_create(date("Y-m-d H:i:s"))->modify('-5 days')->format('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindValue(2, $_GET['id'], PDO::PARAM_INT);
            date_create('2011-04-24')->modify('-1 days')->format('Y-m-d');
            $stmt->execute();

            $msg = 'Jogo atualizado com sucesso!';
            echo '<script>history.pushState({}, "", "")</script>';
            header('Location: painel-adm.php?sort=' . $orderBy . '');
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
        // Output message
    }
    // Get the boardgame from the boardgames table

} else {
    exit('ID não especificado!');
}
