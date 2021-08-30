<?php
echo('<pre>');
// var_dump($_FILES);
echo('</pre>');

// ファイルがアップロードされたら、アップロードされた数を計算しその数だけ
if (isset($_FILES)) {
    for ($i = 0; $i < count($_FILES["upload_file"]["name"]); $i++ ) {
        echo $_FILES["upload_file"]["name"][$i];
        echo "<br>";
        echo $_FILES["upload_file"]["tmp_name"][$i];
        echo "<br>";
        move_uploaded_file($_FILES["upload_file"]["tmp_name"][$i], "./Img/" . $_FILES["upload_file"]["name"][$i]);
        echo '<p><img src="', "./Img/" . $_FILES["upload_file"]["name"][$i], '"></p>';
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
