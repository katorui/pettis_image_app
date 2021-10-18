<?php
session_start();
require_once('../Database/db.php');
$email = 'test@gmail.com';
if (isset($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password'];
}
$db = new Db();
$login_users = $db->login_user($email);
if (!isset($login_users['email'])) {
    echo 'メールアドレス又はパスワードが間違っています。';
    return false;
}
//ハッシュ化されて登録されていたパスワードを送られたパスワードとマッチするか検証
if (password_verify($_POST['password'], $login_users['password'])) {
    session_regenerate_id(true); //session_idを新しく生成し、置き換える
    $_SESSION['email'] = $login_users['email'];
    echo 'ログインしました';
    header('Location: ../index.php');
} else {
    echo 'メールアドレス又はパスワードが間違っています。';
    return false;
}
echo "<pre>";
var_dump($login_users['email']);
echo "</pre>";
var_dump($email);
var_dump($password);
