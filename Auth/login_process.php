<?php
session_start();
require_once('../Database/db.php');
require_once('../errors/PostException.php');
if (isset($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password'];
}
$email = 'pettis@gmail.com';
// $password = 'aaaaaaa';
// $hash = password_hash($email, PASSWORD_DEFAULT);
// $verify = password_verify($email, $hash);
echo "<pre>";
var_dump($login_users);
// var_dump($hash);
// var_dump($verify);
echo "</pre>";

$db = new Db();
$login_users = $db->login_user($email);
$error_messages = [];
try {
    if (!isset($login_users['email'])) {
        $error_messages['error_message'] = 'メールアドレス又はパスワードが間違っています。';
    }
    //ハッシュ化されて登録されていたパスワードを送られたパスワードとマッチするか検証
    if (password_verify($_POST['password'], $login_users['password'])) {
        session_regenerate_id(true); //session_idを新しく生成し、置き換える
        $_SESSION['email'] = $login_users['email'];
        header('Location: ../index.php');
    } else {
        $error_messages['error_message'] = 'メールアドレス又はパスワードが間違っています。';
    }
    if (isset($error_messages)) {
        throw new PostException($error_messages);
    }
} catch (PostException $e) {

}
