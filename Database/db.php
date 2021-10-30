<?php

Class Db
{

    private $user = "root";
    private $pass = "root";
    private $dsn = "mysql:host=localhost;dbname=pettis_image_app;charset=utf8";
    private $dbh = null;

    function __construct(){
        try {
            $dbh = new PDO($this->dsn,$this->user,$this->pass);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbh = $dbh;
        } catch (Exception $e) {
            return "エラー：" . htmlspecialchars($e->getMessage(),
            ENT_QUOTES, 'UTF-8') . "<br>";
        }
    }

    // 画像ファイル追加
    public function file_insert($post_id, $file_path) {
        try {
            $now = date('Y-m-d H:i:s');
            $sql = "INSERT INTO images (post_id, file_path, created_at) VALUES (?, ?, ?)";
            $stmt = $this->dbh->prepare($sql);
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

//ユーザー投稿db追加
    public function insert_posts($user_id, $title, $body) {
        $sql = "INSERT INTO posts (user_id, title, body) VALUES (?,?,?)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
        $stmt->bindValue(2, $title, PDO::PARAM_STR);
        $stmt->bindValue(3, $body, PDO::PARAM_STR);
        $stmt->execute();
        return $this->dbh->lastInsertId();
    }

    // 投稿数カウント
    public function posts_count() {
        $sql = "SELECT COUNT(id) as cnt FROM posts";
        $counts = $this->dbh->query($sql);
        $count = $counts->fetch();
        return $count['cnt'];
    }

    // ページネーション用セレクト
    public function file_select($start) {
        //postsテーブルから全て取得、imagesテーブルのfilepathカラムをfilepath
        $sql = "SELECT posts.*, GROUP_CONCAT(images.file_path) as file_path FROM posts JOIN images ON posts.id = images.post_id GROUP BY posts.id LIMIT 3 OFFSET :start";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(":start", $start ,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ログイン認証
    public function login_user($email) {
        $sql = "SELECT * FROM users where email = :email";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(":email", $email ,PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
        // $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function post_delete($id) {
        $sql = "DELETE FROM posts join images ON posts.id = images.post_id GROUP BY posts.id where id = :id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(":id", $id ,PDO::PARAM_STR);
        return $stmt->execute();
        // $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function test_select($id) {
        $sql = "SELECT posts.*,  FROM posts join images ON posts.id = images.post_id GROUP BY posts.id";
        $stmt = $this->dbh->prepare($sql);
        // $stmt->bindValue(":id", $id ,PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // GROUP BY posts.id where id = :id"


}
