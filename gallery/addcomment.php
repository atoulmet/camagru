<?php
  session_start() or die("Failed to start session\n");
  include("../db-connect.php");
  $id_pic = htmlentities($_GET['id_pic'], ENT_QUOTES | ENT_HTML5);
  $com = htmlentities($_GET['com'], ENT_QUOTES | ENT_HTML5);
  if (!isset($_SESSION['logged_on_user']))
    exit("Veuillez vous connecter pour commenter") ;
  $req = $bdd->prepare('INSERT INTO comments(id_comment, id_pic, comment, login) VALUES(NULL, ?, ?, ?)');
  $req->execute(array(
    $id_pic,
    $com,
    $_SESSION['logged_on_user']
    ));
  
  $req = $bdd->prepare('SELECT * FROM pictures WHERE id_pic = ?');
  $req->execute(array(
       $id_pic,
      ));
    while ($getautor = $req->fetch()) {
      $autor = $getautor['login'];
      $req = $bdd->prepare('SELECT * FROM users WHERE username = ?');
      $req->execute(array(
            $autor,
          ));
          while ($getmail = $req->fetch()) {
            $mail = $getmail['email'];
          }
    }
    echo $autor;
    echo $mail;
    $sujet = "Nouveau commentaire sur votre photo ".$id_pic."!";
    $message_html = "<html><head></head><body><b>Bonjour ".$autor.",</br>votre photo ".$id_pic."vient tout juste d'être commentée par ".$_SESSION['logged_on_user']."! Venez vite voir ce qu'il a écrit : http://localhost:8888/camagru/gallery/gallery.php!</br>";
    $message_txt = "Bonjour ".$autor.", votre photo ".$id_pic."vient tout juste d'être commentée par ".$_SESSION['logged_on_user']."! Venez vite voir ce qu'il a écrit : http://localhost:8888/camagru/gallery/gallery.php!";
    include("../session/mail.php");
    send_mail($mail, $sujet, $message_txt, $message_html);
    echo "Un mail de réinitialisation vient de vous être envoyé";
?>