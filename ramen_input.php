<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <title>ラーメン記録帳（入力）</title>
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
    label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
      color: #333;
    }
    input[type="text"],
    input[type="date"],
    textarea,
    input[type="file"] {
      width: 100%;
      padding: 10px;
      font-size: 1em;
      border: 1px solid #ccc;
      border-radius: 6px;
      margin-bottom: 20px;
      background-color: #fff;
    }
    textarea {
      resize: vertical;
    }
    .rating-group {
      margin-bottom: 20px;
    }
    .rating-group label {
      margin-right: 12px;
      font-weight: normal;
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
    .back-link {
      display: inline-block;
      margin-top: 20px;
      color: #ff8c00;
      font-weight: bold;
      text-decoration: none;
    }
    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <form action="ramen_create.php" method="POST" enctype="multipart/form-data">
    <fieldset>
      <legend>ラーメン記録を入力</legend>

      <label for="shop_name">店名：</label>
      <input type="text" name="shop_name" id="shop_name" required>

      <label for="visit_date">訪問日：</label>
      <input type="date" name="visit_date" id="visit_date" required>

      <label for="comment">コメント：</label>
      <textarea name="comment" id="comment" rows="4" placeholder="例：スープが濃厚で最高！"></textarea>

      <label>評価：</label>
      <div class="rating-group">
        <label><input type="radio" name="rating" value="1" required>★☆☆☆☆</label>
        <label><input type="radio" name="rating" value="2">★★☆☆☆</label>
        <label><input type="radio" name="rating" value="3">★★★☆☆</label>
        <label><input type="radio" name="rating" value="4">★★★★☆</label>
        <label><input type="radio" name="rating" value="5">★★★★★</label>
      </div>

      <label for="image">写真アップロード：</label>
      <input type="file" name="image" id="image" accept="image/*">

      <button type="submit">📋 記録する</button>
    </fieldset>
  </form>

  <a class="back-link" href="ramen_read.php">← 一覧画面へ</a>
</body>
</html>
