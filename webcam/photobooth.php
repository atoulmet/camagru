<?php 
if (session_start() === false)
{
	echo "Erreur inattendue\n";
	exit ;
} 
if (!isset($_SESSION['logged_on_user']) || !$_SESSION['logged_on_user'])
{
    $_SESSION['failed_attempt'] = 1;
    header("Location: ../index.php");
}
?>
<head lang="fr">
    <link href='http://fonts.googleapis.com/css?family=Julius+Sans+One' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="../css/style.css?<?php echo time(); ?>" />
		<meta charset="utf-8">
        <meta content="" name="keywords">
        <title>Camagru</title>
        <h1><table class="caca"><td class="title"><a href="../index.php">Camagru</a></td></table></h1>
	</head>

<body>

<?php
    if (isset($_SESSION['logged_on_user']) && $_SESSION['logged_on_user'])
    {
    echo '<div id="hello">'."Bonjour ".$_SESSION['logged_on_user'].'<br />';
    echo '<a href="../session/logout.php">Logout</a><br/></div><div id="warning"></div>';
    echo '<a href="../gallery/gallery.php">Accéder à la Galerie</a><br/></div><br></head>';
    }
    ?>
<div id="conteneur">
    <div class="element">
    <div id="filters">
       <button id="img1"><img class="img1" src="filters/img1.png" alt="boo"></button>
       <button id="img2" ><img class="img2" src="filters/img2.png" alt="thug"></button>
       <button id="img3" ><img class="img3" src="filters/img3.png" alt="meme"></button>
     </div>
     </br>
     </br>
    <video id="video"></video></br>
<button id="startbutton">Prendre une photo</button>
</br>
<label class="file" title="">
<input type="file" accept="image/*" name="uploadpicture" id="uploadpicture" onchange="this.parentNode.setAttribute('title', this.value.replace(/^.*[\\/]/, ''))" />
<input id="uploadsubmitbutton" type="submit" value="Fusionner les images" name="submit"> 
</label>
</br><a id="dl-btn" href="#" download="camagru_booth.png">Télécharger</a>
</br>
<canvas id="canvas"></canvas>

<!-- <img src="" id="preview" alt="preview"> -->

    
</div>
<div class="element">
<div id="side">
<?php include_once("./sidebar.php");?>
<!-- https://www.w3schools.com/w3css/tryit.asp?filename=tryw3css_sidebar -->
</div>
</div>
</div>
<script type="application/javascript" src="webcam.js?2"></script>
</body>

