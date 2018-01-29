<?php
if (session_start() === false)
{
	echo "Erreur inattendue\n";
	exit ;
}
include("./mail.php");
include("../db-connect.php");
?>
<!DOCTYPE html>
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
    <a href="../index.php"><h1><table class="caca"><td class="title">Camagru</td></table></h1></a>
      <div class="text"><form action="create_account.php" method="post">
          <label for="email">Adresse email : </label>
          <input type="email" name="email" id="email" placeholder="email" value="" />
          <br />
          <br />
          <label for="login">Identifiant : </label>
           <input type="text" name="login" id="login" placeholder="login" value="" />
          <br />
          <br />
          <label for="passwd">Mot de passe : </label>
          <input type="password" name="passwd" id="passwd" placeholder="password" value="" />
          <input type="submit" name="submit" value="OK" />
      </form>
      </div>
      </body>
      </html>
<?php 

function validPassword($pwd)
{
	return (preg_match("#(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $pwd));
}

if (isset($_POST['login']) && isset($_POST['passwd']) && isset($_POST['email']))
{
  $login = htmlentities($_POST['login'], ENT_QUOTES | ENT_HTML5);
  $passwd = htmlentities($_POST['passwd'], ENT_QUOTES | ENT_HTML5);
  $email = $_POST['email'];
  if (!$login) 
{
	echo "<p>Veuillez renseigner un nom d'utilisateur.</p>\n";
  echo '</br><a href="../index.php"><p> Retour à l accueil </p></a>';
	return ;
}
else if (!$email)
{
	echo "<p>Veuillez renseigner une adresse mail.</p>\n";
  echo '</br><a href="../index.php"><p> Retour à l accueil </p></a>';
	return ;
}
else if (!$passwd)
{
	echo "<p>Veuillez renseigner un mot de passe.</p>\n";
  echo '</br><a href="../index.php"><p> Retour à l accueil </p></a>';
	return ;
}
else if (!validPassword($passwd))
{
		echo "Password must contain at least 8 characters with 1 uppercase, 1 lowercase and 1 digit.";
}
else if ($login && $passwd && $_POST['submit'] === "OK" && $email) ///// Toutes les informations sont bien rentrées
{
  $passwd_hash = hash('whirlpool', $passwd); ///// Mettre dans la fonction après
  /////////////////// DB ///////////////////// Mettre du htmlentities partout

     $req = $bdd->prepare('SELECT username FROM users WHERE username = ?');
      $req->execute(array($login));
    if ($req->fetch())
    {
        // S'il y a un résultat, c'est à dire qu'il existe déjà un pseudo, alors "Ce pseudo est déjà utilisé"
        echo '</br><a href="../index.php"><p> Retour à l accueil </p></a>';
        exit("Ce pseudo est déjà utilisé !\n");
    }
    // Sinon le résultat est nul ce qui veut donc dire qu'il ne contient aucun pseudo, donc on insère <img src="../../bundles/tinymce/vendor/tiny_mce/plugins/emotions/img/smile.png" title=":)" alt=":)">
    else
    {
    $pwd_req = $bdd->prepare('INSERT INTO `users`(`id_user`, `email`, `username`, `password`, `token`) VALUES(NULL, ?, ?, ?, NULL)');
    $pwd_req->execute(array(
      $email,
      $login,
      $passwd_hash
    ));
    $req->closeCursor();
    }
    /////////////////////////////////////////
 $message_html = "<html><head></head><body><b>Bonjour ".$login.",</br>votre inscription sur le site Camagru est bien confirmée</i>.</body></html>";
 $message_txt = "Bonjour ".$login.", votre inscription sur le site Camagru est bien confirmée";
 $sujet = "Camagru";
 $mail = $email;
 send_mail($mail, $sujet, $message_txt, $message_html);
 echo "<p></br></br>".$login.", votre inscription sur Camagru est confirmée </br> Un mail vous a été envoyé sur ".$mail."<p>";
  $_SESSION['logged_on_user'] = $login;
  echo '</br><a href="../index.php"><p> Retour à l accueil </p></a>';
}
}
?>