<?php
session_start();
require_once('Database/db.php');
$db = new Db();
$all_data = $db->all_select();
// echo "<pre>";
// var_dump($all_data);
// echo "</pre>";
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
    <div class="wrapper">
        <div class="container">
            <form action="upload.php" method="POST" enctype="multipart/form-data" class="post_form">
                <input class="title" type="text" name="title" placeholder="タイトル">
                <textarea name="body" id="post" cols="50" rows="5" placeholder="画像説明"></textarea>
                <input type="file" name="upload_file[]" multiple >
                <div class="upload_message">
                <?php if (isset($_SESSION['upload_message'])) {
                    echo $_SESSION['upload_message'];
                    unset($_SESSION['upload_message']); };
                ?>
                </div>
                <div class="checkbox">
                    <input type="checkbox" name="category[]" value="1" id="1">
                    <label for="1">テスト1</label>
                    <input type="checkbox" name="category[]" value="2" id="2">
                    <label for="2">テスト2</label>
                    <input type="checkbox" name="category[]" value="3" id="3">
                    <label for="3">テスト3</label>
                </div>
                <div class="post_btn_area">
                    <input type="submit" value="投稿する" class="btn btn-info rounded-pill post_btn">
                </div>
            </form>
        </div>
    </div>
    <?php foreach ($all_data as $key => $posts_data) :?>
        <div class="posts_wrapper">
            <div class="posts_container">
                <p>ユーザー名 <?php echo $posts_data['id']; ?></p>
                <p>タイトル: <?php echo $posts_data['title']; ?></p>
                <p>画像説明:<?php echo $posts_data['body']; ?></p>
                <ul class="category">
                    <li>カテゴリ</li>
                    <li>カテゴリ</li>
                    <li>カテゴリ</li>
                </ul>
                <div class="images">
                    <?php $images = $posts_data["file_path"];
                    $images = explode(',', $images);?>
                    <!-- <?php var_dump($images); ?> -->
                    <!-- bootstrapModal -->
                    <?php foreach ($images as $key => $image) :?>
                        <img class="image" src="Img/<?php echo  $image; ?>" data-src="<?php echo $image; ?>" data-toggle="modal" data-target="#image">
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <!-- 画像モーダル表示内容 -->
    <div class="modal fade" id="image">
        <div class="modal-dialog">
            <div class="modal-content">
                <img id="modal_image" src="" alt="">
            </div>
        </div>
    </div>
    <!-- CDN -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>
    const image_click = document.querySelectorAll('.image');
    // console.log(image_click)
    for(let i = 0; i < image_click.length; i++) {
        image_click[i].addEventListener('click', function(ele) {
            const modal_image = document.getElementById('modal_image');
            modal_image.setAttribute('src', 'Img/' + this.dataset.src);
            console.log(modal_image)
            console.log(this.dataset.src)
        });
	}
</script>
</body>
</html>
