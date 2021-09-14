<?php

echo "<pre>";
if (isset($_POST)) {
  var_dump($_POST);
}
echo "</pre>";

echo "<pre>";
if (isset($_FILES)) {
  var_dump($_FILES);
}
echo "</pre>";
