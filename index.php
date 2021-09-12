<?php
session_start();
require_once('Database/db.php');
$db = new Db();
$select_files = $db->file_select();
$all_posts_data = $db->posts_select();
?>
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
    <?php if (isset($_SESSION['upload_message'])) {
        echo $_SESSION['upload_message'];
        unset($_SESSION['upload_message']);
    }; ?>
    <div class="wrapper">
        <div class="container">
            <form action="upload.php" method="POST" enctype="multipart/form-data" class="post_form">
                <input class="title" type="text" name="title" placeholder="タイトル">
                <textarea name="body" id="post" cols="50" rows="5" placeholder="画像説明"></textarea>
                <input type="file" name="upload_file[]" multiple>
                <div class="checkbox">
                    <input type="checkbox" name="" value="1">テスト１
                    <input type="checkbox" name="" value="2">テスト２
                    <input type="checkbox" name="" value="3">テスト３
                </div>
                <div class="post_btn_area">
                    <input type="submit" value="投稿する" class="btn btn-info rounded-pill post_btn">
                </div>
            </form>
        </div>
    </div>
    <?php foreach ($all_posts_data as $key => $posts_data) :?>
    <div class="posts_wrapper">
        <div class="posts_container">
            <p>投稿NO.: <?php echo $posts_data['id']; ?></p>
            <p>タイトル: <?php echo $posts_data['title']; ?></p>
            <p>画像説明:<?php echo $posts_data['body']; ?></p>
            <div class="category">
                <p>カテゴリ</p>
                <p>カテゴリ</p>
                <p>カテゴリ</p>
            </div>
            <div class="images">
                <?php $images_data = $db->iamge_select($posts_data['id']); ?>
                <?php foreach ($images_data as $key => $image_data) :?>
                <img src="Img/<?php echo  $image_data["file_path"]; ?> ">
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</body>
</html>
