<?php
include("../db-connect.php");
$req = $bdd->query('SELECT count(*) FROM pictures');
$nb = $req->fetch();
$nbpic = $nb['count(*)'];
if (!isset($_GET['page']) || $_GET['page'] === 0)
    $get = 1;
else
    $get = htmlentities($_GET['page'], ENT_QUOTES | ENT_HTML5);
    $nb_page = ceil($nbpic / 6);
    $last_page = $nb_page;
    $previouspage = $get - 1;
    $nextpage = $get + 1;
if ($get >= $nb_page) {
    $get = $last_page;
    $nextpage = $last_page;
    $previouspage = $get - 1;
}
if ($get <= 1) {
    $start_index = 0;
    $previouspage = 1;
}
else
    $start_index = ($get - 1) * 6; 
  echo '  </br> <body>';
$reponse = $bdd->query('SELECT * FROM pictures ORDER BY date_creation LIMIT '.$start_index. ', 6');
$delete = 0;
$addlikecom = 1;
if (!isset($_SESSION['logged_on_user']))
{
    $addlikecom = 0;
    echo '<div id="warning" style="color:red; width: 100%; text-align: center;">Veuillez vous connecter pour liker, commenter et supprimer vos montages</div><br></br>';
}
echo '<div id="gallery">';
while ($donnees = $reponse->fetch())
{ $id_pic = $donnees['id_pic'];
    if (isset($_SESSION['logged_on_user']) && $_SESSION['logged_on_user'] === $donnees['login'])
        $delete = 1;
?></br>
<div class="pic">
<img class="deletepic" id="delete_<?= $id_pic ?>" onclick="deletePicture(<?=$id_pic?>, <?=$delete?>)" src="icon/delete.png" height=15em width=15em/>
<div style="color: black; text-align: right;">By: <?php echo $donnees['login']; ?></div>
<img src="data:image/jpeg;base64,<?= base64_encode($donnees['pic_binary']) ?>" id= "<?=$id_pic?>"/>
<br>
<div id="likes" style="color: black">
    <img class="likebutton" id="likebutton_<?= $id_pic?>" onclick="addLike(<?=$id_pic?>, <?=$addlikecom?>)"src="icon/like.png" height=15em width=15em/>
    <div class="nblikes" id="nblikes_<?=$id_pic?>" ><?php echo $donnees['likes']; ?> likes</div>
</div>
<?php include("getprevcomment.php"); ?>
<input type="search" size="45em" maxlength="99"><input type="submit" id="submit_<?= $id_pic ?>" value="Ok" onclick="addComment(<?=$id_pic?>, <?=$addlikecom?>)"><br>
</div>
<?php
}
echo '</div>'; 

echo '<div class="pagination" style="text-align: center">'; 
    // if ($nb_page === 1)
    //     echo "Only 1 page";
    // else if ($nb_page === 2)
    //    echo '<a href="http://localhost:8080/camagru/gallery/gallery.php?page=1">1</a><a href="http://localhost:8080/camagru/gallery/gallery.php?page=2">2</a>';
    if ($nb_page >= 2)
    {
        echo '<a href="http://localhost:8080/camagru/gallery/gallery.php?page=1">1</a> ... ';
        echo '<a href="http://localhost:8080/camagru/gallery/gallery.php?page='.$previouspage.'">Précédent</a> ~ ';
        echo $get;
        echo ' ~ <a href="http://localhost:8080/camagru/gallery/gallery.php?page='.$nextpage.'">Suivante</a>';
        echo ' ... <a href="http://localhost:8080/camagru/gallery/gallery.php?page='.$last_page.'">'.$last_page.'</a>';
    }
    else
        echo 'Page 1';
    echo '</div>';
    $reponse->closeCursor();?>
</body>

