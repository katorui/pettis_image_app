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

    public function file_insert($file_path) {
        $dbh = $this->dbc();
        $post_id = 1;
        $now = date('Y-m-d H:i:s');
        $sql = "INSERT INTO images (post_id, file_path, created_at) VALUES (?, ?, ?)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $post_id, PDO::PARAM_INT);
        $stmt->bindValue(2, $file_path, PDO::PARAM_STR);
        $stmt->bindValue(3, $now, PDO::PARAM_STR);
        $stmt->execute();
        echo '追加成功';
    }

    public function file_select() {
        $dbh = $this->dbc();
        $post_id = 1;
        $sql = "SELECT * FROM images WHERE post_id = ?";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1,$post_id,PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
        return $rows;
    }

}
