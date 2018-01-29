<?php
function auth($login, $passwd)
{
	require("../db-connect.php");
  $passwd_hash = hash('whirlpool', $passwd);
  $req = $bdd->prepare('SELECT username, password FROM users WHERE username = ? AND password = ?');
      $req->execute(array($login, $passwd_hash));
    if ($req->fetch())
    {
        // S'il y a un résultat, c'est à dire qu'il existe déjà un pseudo, alors "Ce pseudo est déjà utilisé"
		return (true);
    }
echo "<p style='color:red'>Mot de passe ou Identifiant invalide</p>";
 return (false);
}
 ?>
