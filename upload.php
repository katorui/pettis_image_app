<?php
date_default_timezone_set('Asia/Tokyo');
require_once('Database/db.php');
$db = new Db();

try {

    $MAXS = count($_FILES["upload_file"]["name"] ?? []);
    // var_dump($MAXS);

    for($i=0; $i < $MAXS; $i++)
    {

        $size = $_FILES["upload_file"]["size"][$i] ?? "";
        // var_dump($size);

        if ($size <= 0) {
            throw new Exception('ファイルを選択してください');
        }

        if ($size > 10000000) {
            throw new Exception('ファイルは10M未満にしてください');
        }

        $path = $_FILES["upload_file"]["tmp_name"][$i] ?? "";
        $mime_type = mime_content_type($path);

        switch($mime_type) {
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
                echo $file_path . " をアップロードしました";
                $db->file_insert($file_path);
            } else {
                throw new Exception('アップロードに失敗しました');
            }
        }
    }

} catch (Exception $e) {
    echo $e->getMessage();
}
