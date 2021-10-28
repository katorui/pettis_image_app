<?php
ini_set('display_errors', "On");
session_start();
require_once('../Database/db.php');

$csrf_token = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 16);
$_SESSION["csrf_token"] = $csrf_token;
var_dump($_SESSION["csrf_token"]);
// $email = 'test@gmail.com';
// $db = new Db();
// $login_users = $db->login_user($email);
?>
<body>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="../Css/auth.css">
    <title>login</title>
    <div class="container">
        <h1 class="title">
            LOGIN
        </h1>
        <form action="login_process.php" method="post">
            <div class="message">
                <?php
                    if (isset($_SESSION['error_message'])) {
                        echo $_SESSION['error_message'];
                        unset($_SESSION['error_message']);
                    }
                ?>
            <div class="message">
                <?php
                    if (isset($_SESSION['csrf_token_error'])) {
                        echo $_SESSION['csrf_token_error'];
                        unset($_SESSION['csrf_token_error']);
                    }
                ?>
            </div>
            <div class="message">
                <?php
                    if (isset($_SESSION['error_message'])) {
                        echo $_SESSION['error_message'];
                        unset($_SESSION['error_message']);
                    }
                ?>
            </div>
            <div class="message">
                <?php
                    if (isset($_SESSION['input_email_error'])) {
                        echo $_SESSION['input_email_error'];
                        unset($_SESSION['input_email_error']);
                    }
                ?>
            </div>
            <!-- フォーム入力のエラーメッセージがあれば表示、db検索エラーメッセージがあれば表示 -->
            <div class="item">
                <label for="exampleFormControlInput1" class="form-label"><label>
                <!-- value値に確認画面の値を設定 -->
                <input type="text" name="email" placeholder="EMAIL"  value="">
            </div>
            <!-- エラーメッセージ -->
            <div class="message">
                <?php
                    if (isset($_SESSION['input_password_error'])) {
                        echo $_SESSION['input_password_error'];
                        unset($_SESSION['input_password_error']);
                    }
                ?>
            </div>
            <div class="item">
                <label for="exampleFormControlInput1" class="form-label"><label>
                <input type="password" name="password" placeholder="PASSWORD" >
            </div>
            <div class="item">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION["csrf_token"] ?>">
            </div>
            <div class="button">
                <input class="btn btn-info rounded-pill post_btn" type="submit" value="LOGIN">
            </div>
        </form>
    </div>
</body>
