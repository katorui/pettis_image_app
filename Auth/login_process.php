<?php
ini_set('display_errors', "On");
session_start();
require_once('../Database/db.php');
require_once('../errors/PostException.php');

if (isset($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password'];
}


$input_error = [];
try {
if (empty($email)) {
    $input_error['input_email_error'] = "メールアドレスを入力してください";
    // $_SESSION['input_error']['email'] = "メールアドレスを入力してください";
}

if (empty($password)) {
    $input_error['input_password_error']= "パスワードを入力してください";
    // $_SESSION['input_error']['password'] = "パスワードを入力してください";
}
var_dump($input_error);
exit;
if (count($input_error) > 0) {
    throw new PostException($input_error);
}

} catch (PostException $e) {
    $errors = $e->getArrayMessage();
    if(!empty($errors->input_email_error)) $_SESSION['input_email_error'] = $errors->input_email_error;
    if(!empty($errors->input_password_error)) $_SESSION['input_error'] = $errors->input_password_error;
    echo $_SESSION['input_error'];
    // header('Location: login.php');
}
exit;

// $email = 'test2@gmail.com';
// $password = 'pettistest2';
// $hash = password_hash($password, PASSWORD_DEFAULT);
// $verify = password_verify($email, $hash);

$db = new Db();
$login_users = $db->login_user($email);
echo "<pre>";
echo "</pre>";
$error_messages = [];
try {
    if (!isset($login_users['email'])) {
        $error_messages['error_message'] = 'メールアドレス又はパスワードが間違っています';
    }
    //ハッシュ化されて登録されていたパスワードを送られたパスワードとマッチするか検証
    if (password_verify($password, $login_users['password'])) {
        session_regenerate_id(true); //session_idを新しく生成し、置き換える
        $_SESSION['email'] = $login_users['email'];
        var_dump($_SESSION['email']);
        // header('Location: ../index.php');
    } else {
        $error_messages['error_message'] = 'メールアドレス又はパスワードが間違っています';
    }
    if (isset($error_messages)) {
        throw new PostException($error_messages);
    }
} catch (PostException $e) {
    $errors = $e->getArrayMessage();
    if(!empty($errors->error_message)) $_SESSION['error_message'] = $errors->error_message;
    echo $_SESSION['error_message'];
    header('Location: login.php');
}
