<?php if (session_start() === false)
{
	echo "Erreur inattendue\n";
	exit ;
}
  function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
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
      <div class="text"><form action="pwd_reinit.php" method="post">
          <label for="login">Identifiant : </label>
           <input type="text" name="login" id="login" placeholder="login" value="" />
          <br />
          <br />
          <input type="submit" name="submit" value="OK" />
          </form>
      </div>
      </body>
   

 <?php 
    require("../db-connect.php");
    include("./mail.php");
    if (isset($_POST['login']) && $_POST['submit'] === "OK") 
    {
        $login = htmlentities($_POST['login'], ENT_QUOTES | ENT_HTML5);
        $randomString = generateRandomString();
        $req_log = $bdd->prepare('SELECT * FROM users WHERE username = ?');
        $req_log->execute(array($login));
      if ($data = $req_log->fetch()) 
      {
        $mail = $data['email'];
        $req_reinit = $bdd->prepare('UPDATE users SET token = :token WHERE username = :username');
        $req_reinit->execute(array(
	    'token' => $randomString,
	    'username' => $login
	    ));
        $message_html = "<html><head></head><body><b>Bonjour,</br>Pour réinitialiser votre mot de passe, veuillez cliquer sur le lien ci-dessous et entrer le mot de passe temporaire suivant</br>
        <a href='localhost:8080/camagru/session/change_pwd.php'>localhost:8080/camagru/session/change_pwd.php</a> </br>Mot de passe temporaire : ".$randomString."</i>.</body></html>";
        $message_txt = "Pour réinitialiser votre mot de passe, veuillez entrer le lien ci-dessous et entrer le mot de passe temporaire suivant : localhost:8080/camagru/session/change_pwd.php et votre mot de passe temporaire".$randomString;
        $sujet = "Camagru - Réinitialisation de votre mot de passe";
        send_mail($mail, $sujet, $message_txt, $message_html);
        echo "Un mail de réinitialisation vient de vous être envoyé";
      }
      else
        echo "Login invalide";
    }
?> 
   </html>
