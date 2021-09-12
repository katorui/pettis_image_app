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

    // 投稿一覧表示
    public function posts_select() {
        $dbh = $this->dbc();
        $sql = "SELECT * FROM posts";
        $stmt = $dbh->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function file_select() {
        $dbh = $this->dbc();
        $post_id = 2;
        $sql = "SELECT * FROM images WHERE post_id = ?";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1,$post_id,PDO::PARAM_INT);
        $stmt->execute();
        $files = $stmt->fetch(PDO::FETCH_ASSOC);
        return $files;
    }

public function iamge_select($post_id) {
        $dbh = $this->dbc();
        $sql = "SELECT * FROM images INNER JOIN posts ON images.post_id = posts.id where post_id = ?";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1,$post_id,PDO::PARAM_INT);
        $stmt->execute();
        $test_files = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $test_files;
    }

    // public function test_select2() {
    //     $dbh = $this->dbc();
    //     $sql = "SELECT * FROM images INNER JOIN posts ON images.post_id = posts.id";
    //     $stmt = $dbh->query($sql);
    //     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     return $result;
    // }

}
