<?php
$id = $_GET['id'] ?? '';
if (!$id) exit('IDが指定されていません');

$db_name = "";
$db_host = "";
$db_id   = "";
$db_pw   = "";

try {
  $pdo = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8mb4;port=3306", $db_id, $db_pw);
} catch (PDOException $e) {
  exit('DB接続エラー：' . $e->getMessage());
}

$sql = 'DELETE FROM ramen_table WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();

header('Location: ramen_read.php');
exit();
?>
