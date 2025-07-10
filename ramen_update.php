<?php
// 入力チェック
if (
  !isset($_POST['id']) ||
  !isset($_POST['shop_name']) || $_POST['shop_name'] === '' ||
  !isset($_POST['visit_date']) || $_POST['visit_date'] === '' ||
  !isset($_POST['rating']) || $_POST['rating'] === ''
) {
  exit('入力エラー：必須項目が入力されていません');
}

$id = (int)$_POST['id'];
$shop_name = $_POST['shop_name'];
$visit_date = $_POST['visit_date'];
$comment = $_POST['comment'] ?? '';
$rating = (int)$_POST['rating'];

// DB接続
$db_name = "";
$db_host = "";
$db_id   = "";
$db_pw   = "";

try {
  $pdo = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8mb4;port=3306", $db_id, $db_pw);
} catch (PDOException $e) {
  exit('DB接続エラー：' . $e->getMessage());
}

// UPDATE
$sql = 'UPDATE ramen_table SET shop_name = :shop_name, visit_date = :visit_date, comment = :comment, rating = :rating, updated_at = NOW() WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':shop_name', $shop_name, PDO::PARAM_STR);
$stmt->bindValue(':visit_date', $visit_date, PDO::PARAM_STR);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
$stmt->bindValue(':rating', $rating, PDO::PARAM_INT);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

try {
  $stmt->execute();
  header('Location: ramen_read.php');
  exit();
} catch (PDOException $e) {
  exit('更新エラー：' . $e->getMessage());
}
