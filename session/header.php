<?php
	if (isset($_SESSION['logged_on_user']) && $_SESSION['logged_on_user'])
		{
		echo '<div id="hello"><p>'."Bonjour ".$_SESSION['logged_on_user'].'<br />';
		echo '<a href="./session/logout.php">Logout</a><br/></div>'; //Si je veux avoir notif sans refresh la page, il faut faire AJAX (exécuter code côté serveur)
    }
	else
	{
		if (isset($_SESSION['failed_attempt']) && $_SESSION['failed_attempt'] === 1) {
            echo '<p style="color:red">Veuillez vous connecter pour accéder au Photobooth</p>';
            $_SESSION['failed_attempt'] = 0;
        }
		echo '<div id="hello"><p><a href="./session/login.php">Se connecter</a><br />';
		echo '<a id="sign_up" href="./session/create_account.php">Inscription</a></div></br>';
	}
?>
</header>