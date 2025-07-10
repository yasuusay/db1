<?php
// 入力チェック
$id = $_GET['id'] ?? '';
if (!$id) {
  exit('IDが指定されていません');
}

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

// 該当IDのデータ取得
$sql = 'SELECT * FROM ramen_table WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$record = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$record) exit('指定された記録が見つかりません');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ラーメン記録の編集</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #fffaf5;
      margin: 0 auto;
      max-width: 600px;
      padding: 30px;
    }
    fieldset {
      border: 2px solid #ff8c00;
      border-radius: 10px;
      padding: 30px;
      background-color: #fffefc;
      box-shadow: 0 0 10px rgba(255, 140, 0, 0.1);
    }
    legend {
      font-size: 1.5em;
      color: #ff8c00;
      font-weight: bold;
      padding: 0 10px;
    }
    label, input, textarea {
      display: block;
      width: 100%;
      margin-bottom: 20px;
    }
    textarea {
      resize: vertical;
    }
    .rating-group label {
      margin-right: 10px;
    }
    button {
      background-color: #ff8c00;
      color: white;
      font-weight: bold;
      border: none;
      padding: 12px;
      width: 100%;
      border-radius: 6px;
      font-size: 1em;
      cursor: pointer;
      transition: background 0.3s;
    }
    button:hover {
      background-color: #e57c00;
    }
  </style>
</head>
<body>
  <form action="ramen_update.php" method="POST">
    <fieldset>
      <legend>ラーメン記録を編集</legend>

      <input type="hidden" name="id" value="<?= htmlspecialchars($record['id'], ENT_QUOTES) ?>">

      <label for="shop_name">店名：</label>
      <input type="text" name="shop_name" id="shop_name" value="<?= htmlspecialchars($record['shop_name'], ENT_QUOTES) ?>" required>

      <label for="visit_date">訪問日：</label>
      <input type="date" name="visit_date" id="visit_date" value="<?= htmlspecialchars($record['visit_date'], ENT_QUOTES) ?>" required>

      <label for="comment">コメント：</label>
      <textarea name="comment" id="comment" rows="4"><?= htmlspecialchars($record['comment'], ENT_QUOTES) ?></textarea>

      <label>評価：</label>
      <div class="rating-group">
        <?php for ($i = 1; $i <= 5; $i++): ?>
          <label><input type="radio" name="rating" value="<?= $i ?>" <?= $record['rating'] == $i ? 'checked' : '' ?>><?= str_repeat('★', $i) ?><?= str_repeat('☆', 5 - $i) ?></label>
        <?php endfor; ?>
      </div>

      <button type="submit">✏️ 更新する</button>
    </fieldset>
  </form>
</body>
</html>
