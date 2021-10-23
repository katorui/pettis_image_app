<?php
ini_set('display_errors', "On");
session_start();
require_once('../Database/db.php');
require_once('../errors/PostException.php');

//テストアドレスtest2@gmail.com
//テストパスワードpettistest2

if (isset($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password'];
}

$input_errors = [];
try {
    if (empty($email)) {
        $input_errors['input_email_error'] = "メールアドレスを入力してください";
        // $_SESSION['input_errors']['email'] = "メールアドレスを入力してください";
    }

    if (empty($password)) {
        $input_errors['input_password_error']= "パスワードを入力してください";
        // $_SESSION['input_errors']['password'] = "パスワードを入力してください";
    }

    if (count($input_errors) > 0) {
        throw new PostException($input_errors);
    }

} catch (PostException $e) {
    $input_errors = $e->getArrayMessage();
    if(!empty($input_errors->input_email_error)) $_SESSION['input_email_error'] = $input_errors->input_email_error;
    if(!empty($input_errors->input_password_error)) $_SESSION['input_password_error'] = $input_errors->input_password_error;
    header('Location: login.php');
    exit;
}

$error_messages = [];
try {
    $db = new Db();
    $login_users = $db->login_user($email);
    echo "<pre>";
    // var_dump($login_users);
    echo "</pre>";

    if (!isset($login_users['email'])) {
        $error_messages['error_message'] = 'メールアドレス又はパスワードが間違っています';
    }
    //ハッシュ化されて登録されていたパスワードを送られたパスワードとマッチするか検証
    if (password_verify($password, $login_users['password'])) {
        session_regenerate_id(true); //session_idを新しく生成し、置き換える
        $_SESSION['email'] = $login_users['email'];
        var_dump($_SESSION['email']);
        header('Location:/');
        exit;
    } else {
        $error_messages['error_message'] = 'メールアドレス又はパスワードが間違っています';
    }

    if (isset($error_messages)) {
        throw new PostException($error_messages);
    }

} catch (PostException $e) {
    $errors = $e->getArrayMessage();
    if(!empty($errors->error_message)) $_SESSION['error_message'] = $errors->error_message;
    header('Location: login.php');
    exit;
}
