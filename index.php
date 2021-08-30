<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Css/views.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>トップページ</title>
</head>
<body>
  <div class="app_title">
      <h1>画像掲示板</h1>
  </div>
  <div class=wrapper>
      <form action="upload.php" method="POST" enctype="multipart/form-data" class="post_form">
          <input class="title" type="text" name="title" placeholder="タイトル">
          <textarea name="body" id="post" cols="50" rows="5" placeholder="画像説明"></textarea>
          <input type="file" multiple name="upload_file[]">
          <div class="checbox">
              <input type="checkbox" name="" value="1">テスト１
              <input type="checkbox" name="" value="2">テスト２
              <input type="checkbox" name="" value="3">テスト３
          </div>
          <input type="submit" value="投稿する" class="btn btn-primary rounded-pill">
      </form>
  </div>
</body>
</html>
