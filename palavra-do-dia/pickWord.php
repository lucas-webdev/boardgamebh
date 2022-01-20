<?php
include '../lista/utils/functions.php';
header("Content-Type: application/json; charset=UTF-8");

$pdo = pdo_connect_mysql();
$sql = "SELECT word FROM WORDS_LIST LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$word = $stmt->fetch();

$response['word'] = $word['word'];
$json_response = json_encode($response);

echo $json_response;

return $json_response;

?>