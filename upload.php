<?php
session_start();
ini_set('display_errors', "On");
date_default_timezone_set('Asia/Tokyo');
require_once('Database/db.php');
// var_dump(count($_FILES["upload_file"]["name"]));
echo ("<pre>");
var_dump($_FILES);
var_dump($_POST);
// var_dump(mb_strlen($_POST['title']));
echo ("</pre>");
// exit;


// try {
//     if (mb_strlen($_POST['title']) > 20) {
//         throw new Exception('文字数が多すぎます');
//     }
// } catch (Exception $e) {
//     $_SESSION['title_error_message'] = $e->getMessage();
//     header('Location: index.php');
//     exit;
// }

// try {
//     if (mb_strlen($_POST['body']) > 200) {
//         throw new Exception('文字数が多すぎます');
//     }
// } catch (Exception $e) {
//     $_SESSION['body_error_message'] = $e->getMessage();
//     header('Location: index.php');
//     exit;
// }


try {
    $MAXS = count($_FILES["upload_file"]["name"] ?? []);
    if ($MAXS > 3) {
        throw new Exception('ファイルは3つまで選択可能です');
    }
    for ($i=0; $i < $MAXS; $i++)
    {
        $size = $_FILES["upload_file"]["size"][$i] ?? "";
        if ($size <= 0) {
            throw new Exception('ファイルを選択してください');
        }

        if ($size > 10000000) {
            throw new Exception('ファイルは10M未満にしてください');
        }
// 三項演算子
        $path = $_FILES["upload_file"]["tmp_name"][$i] ?? "";
        $mime_type = mime_content_type($path);
// minetype検証
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
                throw new Exception('ファイル形式が不正です');
        }

        if (is_uploaded_file($path)) {
            $random_number = uniqid(mt_rand(), true);
            $date = date("YmdHis"); //日時取得
            $file_path = $date . $random_number . "." . $extention; //保存ディレクトリ作成
            if (move_uploaded_file($path, "Img/" . $file_path)) {
                $db = new Db();
                // if ($db->file_insert($file_path)) {
                //     $_SESSION['upload_message'] = "画像を投稿しました";
                //     // header('Location: index.php');
                //     exit;
                // } else {
                //     throw new Exception('投稿に失敗しました');
                // }
            } else {
                throw new Exception('投稿に失敗しました');
            }
        }
    }

} catch (Exception $e) {
    $_SESSION['upload_message'] = $e->getMessage();
    header('Location: index.php');
    exit;
}
