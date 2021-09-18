<?php
ini_set('display_errors', "On");

Class Db

{

    public function dbc() {

        $user = "root";
        $pass = "root";
        $dsn = "mysql:host=localhost;dbname=pettis_image_app;charset=utf8";

        try {
            $dbh = new PDO($dsn,$user,$pass);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbh;
            // var_dump($dbh);
        } catch (Exception $e) {
            return "エラー：" . htmlspecialchars($e->getMessage(),
            ENT_QUOTES, 'UTF-8') . "<br>";
        }

    }
    // 画像ファイル追加
    public function file_insert($file_path) {
        try {
            $dbh = $this->dbc();
            $post_id = 3;
            $now = date('Y-m-d H:i:s');
            $sql = "INSERT INTO images (post_id, file_path, created_at) VALUES (?, ?, ?)";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(1, $post_id, PDO::PARAM_INT);
            $stmt->bindValue(2, $file_path, PDO::PARAM_STR);
            $stmt->bindValue(3, $now, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch ( Exception $ex ) {
            // $ex->getMessage();
            return false;
        }
    }

    // 画像取得
    public function iamge_select($post_id) {
        $dbh = $this->dbc();
        $sql = "SELECT * FROM images INNER JOIN posts ON images.post_id = posts.id where post_id = ?";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1,$post_id,PDO::PARAM_INT);
        $stmt->execute();
        $image_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $image_data;
    }

    public function all_select() {
        $dbh = $this->dbc();
        $sql = "SELECT posts.*, GROUP_CONCAT(images.file_path) as file_path FROM posts JOIN images ON posts.id = images.post_id GROUP BY posts.id";
        // $sql = "SELECT posts.id, posts.title, GROUP_CONCAT(images.file_path) FROM posts JOIN images ON posts.id = images.post_id GROUP BY posts.id";
        // $sql = "SELECT posts.id GROUP_CONCAT(images.file_path) AS file_pathes FROM posts JOIN images ON posts.id = images.post_id GROUP BY posts.id";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $image_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $image_data;
    }

    // SELECT posts.*, GROUP_CONCAT(images.file_path) FROM posts LEFT JOIN images ON posts.id = images.post_id GROUP BY posts.id

}
