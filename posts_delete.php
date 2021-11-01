<?php
ini_set('display_errors', "On");
require_once('Database/db.php');

// データベースのpostsとimages両方削除する
if (isset($_GET['id'])) {
  $id = $_GET['id'];
}
var_dump($id);

$db = new Db();
// $db->post_delete($id);
$db->post_delete($id);
header('Location: /');
