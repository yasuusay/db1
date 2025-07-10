<?php
// 入力チェック
if (
  !isset($_POST['shop_name']) || $_POST['shop_name'] === '' ||
  !isset($_POST['visit_date']) || $_POST['visit_date'] === '' ||
  !isset($_POST['rating']) || $_POST['rating'] === ''
) {
  exit('入力エラー：未入力項目があります');
}

$shop_name = $_POST['shop_name'];
$visit_date = $_POST['visit_date'];
$comment = $_POST['comment'] ?? '';
$rating = (int)$_POST['rating'];

// 画像アップロード処理
$image_file_name = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
  $upload_dir = __DIR__ . '/uploads/';
  if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
  }

  $tmp_name = $_FILES['image']['tmp_name'];
  $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
  $new_name = uniqid('img_', true) . '.' . $ext;
  $target_path = $upload_dir . $new_name;

  if (move_uploaded_file($tmp_name, $target_path)) {
    $image_file_name = $new_name;
  } else {
    exit('画像のアップロードに失敗しました');
  }
}

// DB接続
$db_name = "basic-php_php02";
$db_host = "mysql3109.db.sakura.ne.jp";
$db_id   = "basic-php_php02";
$db_pw   = "hogefuga123";

try {
  $dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4;port=3306";
  $pdo = new PDO($dsn, $db_id, $db_pw);
} catch (PDOException $e) {
  exit('DB接続エラー：' . $e->getMessage());
}

// INSERT
$sql = 'INSERT INTO ramen_table (shop_name, visit_date, comment, rating, image, created_at, updated_at)
        VALUES (:shop_name, :visit_date, :comment, :rating, :image, NOW(), NOW())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':shop_name', $shop_name, PDO::PARAM_STR);
$stmt->bindValue(':visit_date', $visit_date, PDO::PARAM_STR);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
$stmt->bindValue(':rating', $rating, PDO::PARAM_INT);
$stmt->bindValue(':image', $image_file_name, PDO::PARAM_STR);

try {
  $stmt->execute();
  header('Location:ramen_read.php');
  exit();
} catch (PDOException $e) {
  exit('SQLエラー：' . $e->getMessage());
}
