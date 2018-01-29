<?php
if (session_start() === false)
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
    <link rel="stylesheet" type="text/css" href="css/style.css">
		<meta charset="utf-8">
        <meta content="" name="keywords">
        <title>Camagru</title>
       <div class="con"><h1><table class="caca"><td class="title">Camagru</td></table></h1></div>
        <?php include_once("./session/header.php"); ?>
	</head>
<body>
    </br><a href="webcam/photobooth.php">Accéder au Photobooth</a></br>
    <a href="gallery/gallery.php">Accéder à la Galerie</a>
</body>
</html>
