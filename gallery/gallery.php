<?php
session_start() or die("Failed to start session\n");
?>
<style type="text/css"> body {
    display: table;
  }</style>
<head lang="fr">
    <link href='http://fonts.googleapis.com/css?family=Julius+Sans+One' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="../css/style.css?<?php echo time(); ?>" />
		<meta charset="utf-8">
        <meta content="" name="keywords">
		<title>Camagru</title>

<h1><table class="caca"><td class="title"><a href="../index.php">Camagru</a></td></table></h1>
<?php
    if (isset($_SESSION['logged_on_user']) && $_SESSION['logged_on_user'])
    {
    echo '<div id="hello">'."Bonjour ".$_SESSION['logged_on_user'].'<br />';
    echo '<a href="../session/logout.php">Logout</a><br/></div><br></head>';
    echo '<a href="../webcam/photobooth.php">Accéder au Photobooth</a><br/></div><br></head>';
    }
    else {
        echo '<div><a href="../session/login.php">Se connecter</a><br/></div></head>';
        echo '<a href="../webcam/photobooth.php">Accéder au Photobooth</a><br/></div><br></head>';
    }
include("../db-connect.php");
include("paginate.php");
?>
<script type="application/javascript" src="gallery.js?2"></script>