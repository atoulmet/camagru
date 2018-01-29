<?php
  session_start() or die("Failed to start session\n");
  include("../db-connect.php");
  if (!isset($_SESSION['logged_on_user']))
    exit("Veuillez vous connecter pour commenter") ;
  $id_pic = htmlentities($_GET['id_pic'], ENT_QUOTES | ENT_HTML5);
  $req = $bdd->prepare('SELECT * FROM pictures WHERE id_pic = ?');
  $req->execute(array(
    $id_pic,
    ));
    while ($data =  $req->fetch()) {
            $nb_likes = $data['likes'];
            $nb_likes++;
            $sql = $bdd->prepare('UPDATE pictures SET likes = :nb_likes WHERE id_pic = :id_pic');
            $sql->execute(array(
                'nb_likes' => $nb_likes,
              'id_pic' => $id_pic,
              ));
    }
?>