<?php
session_start();
require_once('Database/db.php');
require_once('test.php');

$db = new Db();
// dbで取得する数を定義
const MAX= 3;
// 現在ページ数１以下ならば１、それ以外はその数を変数へ代入
if (!isset($_GET['page_id'])) {
    $now = 1;
} else {
    $now = $_GET['page_id'];
}
//スタートページ
$start = ($now - 1) * MAX;
$all_data = $db->file_select($start);
//総数
$total_posts_num = $db->posts_count();
echo "<br>";
// $test = new Test();
// $test->test();
echo "<br>";
// $test = new Test('こんにちは');
// $test->test();
//トータルページ
$total_page = ceil($total_posts_num / MAX);
$prev = max($now - 1, 1);
$next = min($now + 1, $total_page);
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
<?php require_once('header.php') ?>
<!-- ログインユーザー表示 -->
<?php if(isset($_SESSION['email'])) {
    echo 'ようこそ' . $_SESSION['email'] . 'さん';
    // 後で削除
    unset($_SESSION['email']);
}?>
    <div class="wrapper">
        <div class="container">
            <form action="upload.php" method="POST" enctype="multipart/form-data" class="post_form">
            <div class="title_error_message">
                <?php if (isset($_SESSION['title_error_message'])) {
                    echo $_SESSION['title_error_message'];
                    unset($_SESSION['title_error_message']);
                };
                ?>
                </div>
                <input class="title" type="text" name="title" placeholder="タイトル">
                    <div class="body_error_message">
                        <?php if (isset($_SESSION['body_error_message'])) {
                        echo $_SESSION['body_error_message'];
                        unset($_SESSION['body_error_message']);
                        };
                        ?>
                    </div>
                <textarea name="body" id="post" cols="50" rows="5" placeholder="画像説明"></textarea>
                <input type="file" name="upload_file[]" multiple >
                <div class="upload_message">
                <?php if (isset($_SESSION['upload_message'])) {
                    foreach(array_unique($_SESSION['upload_message']) as $error) {
                        echo $error . "<br>";
                    }
                    // var_dump($_SESSION['upload_message']);
                    unset($_SESSION['upload_message']); };
                ?>
                </div>
                <div class="checkbox">
                    <input type="checkbox" name="category[]" value="景色" id="1">
                    <label for="1">テスト1</label>
                    <input type="checkbox" name="category[]" value="人物" id="2">
                    <label for="2">テスト2</label>
                    <input type="checkbox" name="category[]" value="食べ物" id="3">
                    <label for="3">テスト3</label>
                    <input type="checkbox" name="category[]" value="動物" id="4">
                    <label for="4">テスト4</label>
                    <input type="checkbox" name="category[]" value="動物" id="5">
                    <label for="5">テスト5</label>
                    <input type="checkbox" name="category[]" value="動物" id="6">
                    <label for="6">テスト6</label>
                    <input type="checkbox" name="category[]" value="動物" id="7">
                    <label for="7">テスト7</label>
                    <input type="checkbox" name="category[]" value="動物" id="8">
                    <label for="8">テスト8</label>
                    <input type="checkbox" name="category[]" value="動物" id="9">
                    <label for="9">テスト9</label>
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
            <a href="?page_id=<?php echo $prev;?>">前へ</a>
        <?php endif ;?>
    <span><?php echo $now; ?></span>
        <?php if ($now < $total_page) :?>
            <a href="?page_id=<?php echo $next; ?>">次へ</a>
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
