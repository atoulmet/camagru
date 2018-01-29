<?php if (session_start() === false)
{
	echo "Erreur inattendue\n";
	exit ;
}
function validPassword($pwd)
{
	return (preg_match("#(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $pwd));
}
?>

<html>
  <head lang="fr">
    <link href='http://fonts.googleapis.com/css?family=Julius+Sans+One' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
		<meta charset="utf-8">
        <meta content="" name="keywords">
		<title>Camagru</title>
	</head>
  <body>
    <h1><table class="caca"><td class="title"><a href="../index.php">Camagru</a></td></table></h1>
      <div class="text"><form action="change_pwd.php" method="post">
           <label for="login">Identifiant : </label>
           <input type="text" name="login" id="login" placeholder="login" value="" />
          <br />
          <br />
          <label for="tmppwd">Mot de passe temporaire: </label>
          <input type="tmppwd" name="tmppwd" id="tmppwd" placeholder="tmppwd" value="" />
            <br />
            <br />
          <label for="newpwd">Nouveau mot de passe </label>
           <input type="password" name="newpwd" id="newpwd" placeholder="newpwd" value="" />
          <br />
          <br />
          <input type="submit" name="submit" value="OK" />
          </form>
      </div>
      </body>
   

 <?php 
 if (isset($_POST['newpwd']) && isset($_POST['tmppwd']) && isset($_POST['login']) && $_POST['submit'] === "OK") 
 {
   $login = htmlentities($_POST['login'], ENT_QUOTES | ENT_HTML5);
    $newpwd = htmlentities($_POST['newpwd'], ENT_QUOTES | ENT_HTML5);
    $tmppwd = htmlentities($_POST['tmppwd'], ENT_QUOTES | ENT_HTML5);
    if (!validPassword($_POST['newpwd']))
    {
		exit ("Password must contain at least 8 characters with 1 uppercase, 1 lowercase and 1 digit.");
    }
     if (strlen($newpwd) <= 1) {
         echo "<p>Veuillez entrer un nouveau mot de passe<br/><a href='../index.php'>Retour à l'accueil</a></p>";
         exit;
     }
    require("../db-connect.php");
    $req_log = $bdd->prepare('SELECT * FROM users WHERE username = :username AND token = :token');
     $req_log->execute(array(
         'username' => $login, 
         'token' => $tmppwd));
      if ($req_log->fetch()) 
      {
        $req_reinit = $bdd->prepare('UPDATE users SET password = :password, token = NULL WHERE username = :username');
        $req_reinit->execute(array(
            'password' => hash('whirlpool', $newpwd),
            'username' => $login));
            echo "Mot de passe réinitialisé<br/><a href='../index.php'>Retour à l'accueil</a>";
            $_SESSION['logged_on_user'] = $login;
      }
      else
        echo "Login, lien mail ou mot de passe temporaire invalide veuillez réessayer<br/><a href='../index.php'>Retour à l'accueil</a>";
 }
?>
   </html>
