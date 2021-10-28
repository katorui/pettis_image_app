<?php
date_default_timezone_set('Asia/Tokyo');
ini_set('display_errors', "On");
require_once('Database/db.php');
require_once('errors/PostException.php');
session_start();

if (isset($_POST)) {
    $title = $_POST['title'];
    $body = $_POST['body'];
    $csrf_token = $_POST['csrf_token'];
}

$user_id = 5;

$error_messages = [];
try {
    if ($csrf_token !== $_SESSION["csrf_token"]) {
        $error_messages['csrf_token_error'] = "規定のページからアクセスしてください。";
        throw new PostException($error_messages);
    }

    // フォームインプットのバリデーション
    if (mb_strlen($title) > 20) {
        $error_messages['title_error_message'] = 'タイトルは20文字以下で入力してください';
    }

    if (mb_strlen($body) > 200) {
        $error_messages['body_error_message'] = '本文は200文字以下で入力してください';
    }

    // ファイルのバリデーション
    $MAXS = count($_FILES["upload_file"]["name"] ?? []);
    if ($MAXS > 3) {//アップロード数のバリデーション
        $error_messages['upload_message'][] = 'ファイルは3つまで選択可能です';
    }
    for ($i=0; $i < $MAXS; $i++)
    {
        $size = $_FILES["upload_file"]["size"][$i] ?? "";
        if ($size <= 0) {
            $error_messages['upload_message'][] = 'ファイルを選択してください';
        }

        if ($size > 1000000) {
            $error_messages['upload_message'][] = 'ファイルは10M未満にしてください';
        }

        // var_dump($_FILES["upload_file"]["tmp_name"][$i]);
        if (!empty($_FILES["upload_file"]["tmp_name"][$i])) {
            $path[$i] = $_FILES["upload_file"]["tmp_name"][$i] ?? "";
            $mime_type = mime_content_type($path[$i]);//mime_content_typeで拡張子を検出

            // mimetype検証
            switch ($mime_type) {
                case "image/jpeg":
                    $extention = "jpeg";
                    break;
                case "image/png":
                    $extention = "png";
                    break;
                case "image/gif":
                    $extention = "gif";
                    break;
                default:
                    $error_messages['upload_message'][] = 'ファイル形式が不正です';
                }
            }
    }

    if (count($error_messages) > 0) {
        throw new PostException($error_messages);
    }
// // 保存開始
// // DB保存 try
    $db = new Db();
    $post_id = $db->insert_posts($user_id, $title,$body);

    for ($j=0; $j < $MAXS; $j++)
    {
        if (is_uploaded_file($path[$j])) {
            $random_number = uniqid(mt_rand(), true);//乱数作成
            $date = date("YmdHis"); //日時取得
            $file_path[$j] = $date . $random_number . "." . $extention; //保存ディレクトリ作成
            if (move_uploaded_file($path[$j], "Img/" . $file_path[$j])) {
                $db->file_insert($post_id, $file_path[$j]);
            }
        } else {
            $error_messages['upload_message'][] = '投稿に失敗しました';
            throw new PostException($error_messages);
        }
    }
    $_SESSION['upload_message'][] = "画像を投稿しました";
    header('Location: index.php');
    exit;

} catch (PostException $e) {
    $errors = $e->getArrayMessage();
    if(!empty($errors->title_error_message)) $_SESSION['title_error_message'] = $errors->title_error_message;
    if(!empty($errors->body_error_message)) $_SESSION['body_error_message'] = $errors->body_error_message;
    if(!empty($errors->upload_message)) $_SESSION['upload_message'] = $errors->upload_message;
    if(!empty($errors->csrf_token_error)) $_SESSION['csrf_token_error'] = $errors->csrf_token_error;
    header('Location: index.php');
    exit;
}
