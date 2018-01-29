<?php
     include("../db-connect.php");
     $req = $bdd->prepare('SELECT * FROM comments WHERE id_pic = ?');
     $req->execute(array(
          $id_pic,
         ));
    while ($fetchcomments = $req->fetch()) {
        echo '<div class="comment">'.$fetchcomments['comment'].'</br></div>';
    }
?>