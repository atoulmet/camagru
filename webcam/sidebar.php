<?php 
include("../db-connect.php");

$current_user = $_SESSION['logged_on_user'];
$reponse = $bdd->prepare('SELECT * FROM pictures WHERE login = ? ORDER BY date_creation DESC');
$reponse->execute(array($current_user));
while ($donnees = $reponse->fetch())
{
?>
<img src="data:image/jpeg;base64,<?= base64_encode($donnees['pic_binary']) ?>" height=70em width=70em/>
<?php
}

$reponse->closeCursor(); 

?>