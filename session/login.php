<?php if (session_start() === false)
{
	echo "Erreur inattendue\n";
	exit ;
}
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
      <div class="text"><form action="login.php" method="post">
          <label for="login">Identifiant : </label>
           <input type="text" name="login" id="login" placeholder="login" value="" />
          <br />
          <br />
          <label for="passwd">Mot de passe : </label>
          <input type="password" name="passwd" id="passwd" placeholder="password" value="" />
          <input type="submit" name="submit" value="OK" />  <a href="pwd_reinit.php">Mot de passe oublié ?</a>
      </form>
      </div>
      </body>
      </html>
      <?php
include("./auth.php");
if (isset($_POST['login']) && isset($_POST['passwd']))
{
  $login = htmlentities($_POST['login'], ENT_QUOTES | ENT_HTML5);
  $passwd = htmlentities($_POST['passwd'], ENT_QUOTES | ENT_HTML5);
if (auth($login, $passwd) === true)
{
  $_SESSION['logged_on_user'] =  $login;
  echo '<p>Vous êtes connecté</p>';
}
else {
  $_SESSION['logged_on_user'] = '';
  echo "<p style='color:red'>Vous n'êtes pas connecté</p>";
}
echo "<p><br/><a href='../index.php'>Retour à l'accueil</a></p>";
}
?>