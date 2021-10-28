<?php
ini_set('display_errors', "On");
session_start();
require_once('../Database/db.php');
require_once('../errors/PostException.php');
require_once('../security/xss.php');

//テストアドレス test2@gmail.com
//テストパスワード pettistest2
//テストアドレス pettis@gmail.com
//テストパスワード2 testtesttest
if (isset($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $csrf_token = $_POST['csrf_token'];
}
echo "<pre>";
// var_dump($csrf_token);
echo "</pre>";

$input_errors = [];
try {
    // csrf対策
    if ($csrf_token !== $_SESSION["csrf_token"]) {
        $input_errors['csrf_token_error'] = "規定のページからアクセスしてください。";
        throw new PostException($input_errors);
    }
    //メールアドレス空バリデーション
    if (empty($email)) {
        $input_errors['input_email_error'] = "メールアドレスを入力してください";
    }
    //メールアドレス形式バリデーション
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $input_errors['input_email_error'] = "正しい形式で入力してください";
    }
    //パスワード空バリデーション
    if (empty($password)) {
        $input_errors['input_password_error']= "パスワードを入力してください";
    }
    //半角英数8-100位下
    if (!preg_match('/\A[a-z\d]{8,100}+\z/i', "$password")) {
        $input_errors['input_password_error']= "パスワードは半角英数8-100文字で入力してください";
    }

    if (empty($password)) {
        $input_errors['input_password_error']= "パスワードを入力してください";
    }

    if (count($input_errors) > 0) {
        throw new PostException($input_errors);
    }

} catch (PostException $e) {
    $input_errors = $e->getArrayMessage();
    if(!empty($input_errors->input_email_error)) $_SESSION['input_email_error'] = $input_errors->input_email_error;
    if(!empty($input_errors->input_password_error)) $_SESSION['input_password_error'] = $input_errors->input_password_error;
    if(!empty($input_errors->csrf_token_error)) $_SESSION['csrf_token_error'] = $input_errors->csrf_token_error;
    header('Location: login.php');
    exit;
}

$error_messages = [];
try {
    $db = new Db();
    $login_users = $db->login_user($email);
    echo "<pre>";
    // var_dump($login_users['id']);
    echo "</pre>";

    if (!isset($login_users['email'])) {
        $error_messages['error_message'] = 'メールアドレス又はパスワードが間違っています';
    }
    //ハッシュ化されて登録されていたパスワードを送られたパスワードとマッチするか検証
    if (password_verify($password, $login_users['password'])) {
        session_regenerate_id(true); //session_idを新しく生成し、置き換える
        $_SESSION['id'] = $login_users['id'];
        $_SESSION['email'] = $login_users['email'];
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
