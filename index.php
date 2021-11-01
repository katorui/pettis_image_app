<?php
session_start();
require_once('Database/db.php');
require_once('security/xss.php');
// $test = password_hash(testtesttest, PASSWORD_DEFAULT);
// var_dump($test);
// require_once('test.php');
// $aaa = new Test();
// $aaa->test();

if (!isset($_SESSION['email'])) { // ログインされていなければログインページへ
    header('Location: Auth/login.php');
}

$csrf_token = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 16); // 16文字のトークン作成
$_SESSION["csrf_token"] = $csrf_token;
// var_dump($_SESSION["csrf_token"]);
$db = new Db();
const MAX= 3;// dbで取得する数を定義
// 現在ページ数１以下ならば１、それ以外はその数を変数へ代入
if (!isset($_GET['page_id'])) {
    $now = 1;
} else {
    $now = $_GET['page_id'];
}
$start = ($now - 1) * MAX;//スタートページ
$all_data = $db->file_select($start);//総数取得
$total_posts_num = $db->posts_count();//トータルページ取得
$total_page = ceil($total_posts_num / MAX);
$prev = max($now - 1, 1);
$next = min($now + 1, $total_page);
echo "<pre>";
// var_dump($all_data);
echo "</pre>";

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Css/mypage.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>トップページ</title>
</head>
<body>
<!-- ログインユーザー表示 -->
<?php require_once('header.php') ?>
<div class="wrapper">
    <form action="upload.php" method="POST" enctype="multipart/form-data" class="post_form">
        <div class="csrf_error_message">
            <?php
                if (isset($_SESSION['csrf_token_error'])) {
                    echo $_SESSION['csrf_token_error'];
                    unset($_SESSION['csrf_token_error']);}
            ?>
            </div>
        <div class="title_error_message">
            <?php
                if (isset($_SESSION['title_error_message'])) {
                    echo $_SESSION['title_error_message'];
                    unset($_SESSION['title_error_message']);}
            ?>
            </div>
        <input class="title" type="text" name="title" placeholder="タイトル">
        <div class="body_error_message">
            <?php if (isset($_SESSION['body_error_message'])) {
                    echo $_SESSION['body_error_message'];
                    unset($_SESSION['body_error_message']);}
            ?>
        </div>
        <textarea name="body" id="post" cols="50" rows="5" placeholder="画像説明"></textarea>
        <input type="file" name="upload_file[]" multiple >
        <div class="upload_message">
        <?php if (isset($_SESSION['upload_message'])) {
            foreach(array_unique($_SESSION['upload_message']) as $error) {
                echo $error . "<br>";
            }
            unset($_SESSION['upload_message']); };
        ?>
        </div>
        <div class="csrf_token">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION["csrf_token"] ?>">
        </div>
        <div class="post_btn_area">
            <input type="submit" value="投稿する" class="btn btn-info rounded-pill post_btn">
        </div>
    </form>
</div>
<?php foreach ($all_data as $key => $posts_data) :?>
    <div class="posts_wrapper">
        <div class="posts_delete">
            <?php if ($posts_data['user_id'] == $_SESSION['id']):?><!-- ログインユーザーの投稿のみ削除ボタン表示 -->
                <a href="posts_delete.php?id=<?= $posts_data['id']; ?>">削除する</a>
            <?php endif; ?>
        </div>
        <div class="posts_container">
            <p>投稿NO. <?php echo xss($posts_data['id']); ?></p>
            <p>ユーザー名 <?php echo xss($posts_data['user_id']); ?></p>
            <p>タイトル: <?php echo xss($posts_data['title']); ?></p>
            <p>画像説明:<?php echo xss($posts_data['body']); ?></p>
            <div class="images">
                <?php $images = $posts_data["file_path"];
                $images = explode(',', $images);?>
                <?php foreach ($images as $key => $image) :?>
                    <img class="image" src="Img/<?php echo  $image; ?>" data-src="<?php echo $image; ?>">
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<!-- ページネーション -->
<div class="page_link">
    <?php if ($now != 1) :?>
        <a href="?page_id=<?php echo xss($prev);?>">前へ</a>
    <?php endif ;?>
<span><?php echo $now; ?></span>
    <?php if ($now < $total_page) :?>
        <a href="?page_id=<?php echo xss($next); ?>">次へ</a>
    <?php endif ;?>
</div>
<!-- 画像モーダル表示内容 -->
<div class="modal_image" id="modal_image">
    <img class="modal_contents" id="modal_contents" src="">
    <div class="modal_background" id="modal_background">
    </div>
</div>
<!-- CDN -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>
    const image_click = document.querySelectorAll('.image');
    console.log(image_click)
    for(let i = 0; i < image_click.length; i++) {
        image_click[i].addEventListener('click', function(ele) {
            const modal_image = document.getElementById('modal_image');
            const modal_contents = document.getElementById('modal_contents');
            modal_contents.setAttribute('src', 'Img/' + this.dataset.src);
            const modal_background = document.getElementById('modal_background');
            modal_image.classList.add('open');
            modal_background.classList.add('open');
        });
    // 閉じる
        modal_background.addEventListener('click', function() {
        modal_image.classList.remove('open');
        modal_background.classList.remove('open');
    });

    }
</script>
</body>
</html>
