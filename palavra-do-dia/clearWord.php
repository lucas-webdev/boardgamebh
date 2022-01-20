<?php
include '../lista/utils/functions.php';

$pdo = pdo_connect_mysql();
$sql = "DELETE FROM WORDS_LIST LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute();

?>