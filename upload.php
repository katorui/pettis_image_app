<?php
echo('<pre>');
// var_dump($_FILES);
echo('</pre>');

if (isset($_FILES)) {
    for ($i = 0; $i < count($_FILES["upload_file"]["name"]); $i++ ) { // ファイルがアップロードされたら、アップロードされた数を計算
        // echo $_FILES["upload_file"]["name"][$i];
        echo "<br>";
        // echo $_FILES["upload_file"]["tmp_name"][$i];
        echo "<br>";
        $random_number = uniqid(mt_rand(), true); //乱数作成
        $extention = pathinfo($_FILES["upload_file"]["name"][$i], PATHINFO_EXTENSION);//拡張子取得
        $save_dir = "$random_number" . "." . "$extention";
        move_uploaded_file($_FILES["upload_file"]["tmp_name"][$i], "Img/" . $save_dir);
        echo "アップロードしました";
      // $upload_file = $_FILES["upload_file"]["name"][0];
    // echo $upload_file;
    }
}

// もしファイルが送信されたら
// if (isset($_FILES)) {
    // 乱数を作成
    // $image = uniqid(mt_rand(), true);
    // アップロードされたファイルの拡張子を取得
    // $image .= '.' . substr(strrchr($_FILES["upload_file"]["name"][0], '.'), 1);
// }
    // echo $image;
