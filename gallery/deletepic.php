<?php
  session_start() or die("Failed to start session\n");
  include("../db-connect.php");
  $id_pic = htmlentities($_GET['id_pic'], ENT_QUOTES | ENT_HTML5);
  $req = $bdd->prepare('SELECT * FROM pictures WHERE id_pic = ?');
  $req->execute(array(
    $id_pic,
    ));
    while ($data =  $req->fetch()) {
        if (isset($_SESSION['logged_on_user']) && $_SESSION['logged_on_user'] === $data['login'])
        {
            $sql = $bdd->prepare('DELETE FROM pictures WHERE id_pic = :id_pic');
            $sql->execute(array(
              'id_pic' => $id_pic,
              ));
        }
        else
            echo "Mauvais utilisateur. Vous n'avez pas l'autorisation pour supprimer ce montage.";
    }
?>