<?php

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
    public function file_insert($post_id, $file_path) {
        try {
            $dbh = $this->dbc();
            // $post_id = 9;
            $now = date('Y-m-d H:i:s');
            $sql = "INSERT INTO images (post_id, file_path, created_at) VALUES (?, ?, ?)";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(1, $post_id, PDO::PARAM_INT);
            $stmt->bindValue(2, $file_path, PDO::PARAM_STR);
            $stmt->bindValue(3, $now, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch ( Exception $ex ) {
            $ex->getMessage();
            return false;
        }
    }

    public function insert_posts($user_id, $title, $body) {
        $dbh = $this->dbc();
        $sql = "INSERT INTO posts (user_id, title, body) VALUES (?,?,?)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
        $stmt->bindValue(2, $title, PDO::PARAM_STR);
        $stmt->bindValue(3, $body, PDO::PARAM_STR);
        $stmt->execute();
        return $dbh->lastInsertId();
    }

    public function total_posts() {
        $dbh = $this->dbc();
        $sql = "SELECT * FROM posts";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function file_select($start) {
        $dbh = $this->dbc();
        $sql = "SELECT posts.*, GROUP_CONCAT(images.file_path) as file_path FROM posts JOIN images ON posts.id = images.post_id GROUP BY posts.id LIMIT 3 OFFSET :start ORDER BY id DESC";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(":start", $start ,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
