<?php
// DB接続設定
$db_name = "";
$db_host = "";
$db_id   = "";
$db_pw   = "";

try {
  $dsn = "mysql:dbname={$db_name};charset=utf8mb4;host={$db_host};port=3306";
  $pdo = new PDO($dsn, $db_id, $db_pw);
} catch (PDOException $e) {
  exit('DB接続エラー：' . $e->getMessage());
}

$sql = 'SELECT * FROM ramen_table ORDER BY visit_date DESC';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// HTML表示用データ生成
$output = '';
foreach ($result as $record) {
  $stars = str_repeat('★', $record['rating']) . str_repeat('☆', 5 - $record['rating']);
  $img = $record['image'] ? "<img src='uploads/{$record['image']}' alt='ラーメン画像' class='ramen-img'>" : '';
  $comment = nl2br(htmlspecialchars($record['comment'], ENT_QUOTES, 'UTF-8'));

  $output .= "
 <tr>
    <td>{$record['visit_date']}</td>
    <td>" . htmlspecialchars($record['shop_name'], ENT_QUOTES, 'UTF-8') . "</td>
    <td>{$comment}</td>
    <td class='center'>{$stars}</td>
    <td class='center'>{$img}</td>
    <td class='center'><a href='ramen_delete.php?id={$record['id']}' onclick='return confirm(\"削除しますか？\");'>削除</a></td>
    <td class='center'><a href='ramen_edit.php?id={$record['id']}'>編集</a></td>
  </tr>
";
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ラーメン記録帳（一覧）</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #fffaf5;
      margin: 0 auto;
      max-width: 1000px;
      padding: 30px;
    }
    fieldset {
      border: 2px solid #ff8c00;
      border-radius: 10px;
      padding: 20px;
      background-color: #fffefc;
      box-shadow: 0 0 10px rgba(255, 140, 0, 0.1);
    }
    legend {
      font-size: 1.5em;
      color: #ff8c00;
      font-weight: bold;
      padding: 0 10px;
    }
    .nav-buttons {
      margin-bottom: 20px;
      display: flex;
      justify-content: flex-start;
      gap: 10px;
    }
    .nav-buttons a {
      background-color: #ff8c00;
      color: white;
      padding: 10px 20px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: bold;
      transition: background 0.3s;
    }
    .nav-buttons a:hover {
      background-color: #e57c00;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 0 10px rgba(255, 165, 0, 0.15);
    }
    th, td {
      padding: 14px;
      border-bottom: 1px solid #ffe0b0;
    }
    th {
      background-color: #ffb347;
      color: white;
      text-align: left;
    }
    tr:hover {
      background-color: #fff4e5;
    }
    .center {
      text-align: center;
    }
    .ramen-img {
      max-width: 100px;
      border-radius: 6px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }
  </style>
</head>
<body>
  <fieldset>
    <legend>ラーメン記録帳（一覧）</legend>
    <div class="nav-buttons">
      <a href="ramen_input.php">＋ 新しいラーメンを記録</a>
    </div>
    <table>
      <thead>
        <tr>
          <th>日付</th>
          <th>店名</th>
          <th>コメント</th>
          <th>評価</th>
          <th>写真</th>
          <th class="center">削除</th>
          <th class="center">編集</th>
        </tr>
      </thead>
      <tbody>
        <?= $output ?>
      </tbody>
    </table>
  </fieldset>
</body>
</html>
