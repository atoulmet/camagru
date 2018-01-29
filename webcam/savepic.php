<?php
  session_start() or die("Failed to start session\n");
  include("../db-connect.php");
  $rawpic = $_POST['pic'];
  $pic = base64_decode($rawpic);
  $sql = $bdd->prepare('INSERT INTO pictures(`id_pic`, `login`, `date_creation`, `pic_binary`, `likes`) VALUES(NULL, ?, NOW(), ?, ?)');
  $sql->execute(array(
  $_SESSION['logged_on_user'],
  $pic,
  0
    ));
?>