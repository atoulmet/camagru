<?php
require "./database.php";
try {
	$db = new PDO($DB_DSN_INIT, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = "CREATE DATABASE IF NOT EXISTS camagru";
	$test = $db->exec($sql);
	echo "Database Camagru - Created!<br /><br />";
} catch (PDOException $exception) {
	print "Error : " . $exception->getMessage() . ".";
	return (false);
}
try {
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "CREATE TABLE IF NOT EXISTS `users` (
		`id_user` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		`email` VARCHAR(255) NOT NULL,
		`username` VARCHAR(30) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
		`password` VARCHAR(255) NOT NULL,
		`token` VARCHAR(255))";
		$test = $db->exec($sql);   // use exec() because no results are returned
		echo "Table Users - Created!<br /><br />";

		$sql = "CREATE TABLE IF NOT EXISTS `pictures` (
			`id_pic` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			`login` VARCHAR(30) NOT NULL,
			`date_creation` DATETIME NOT NULL,
			`pic_binary` LONGBLOB NOT NULL,
			`likes` INT NOT NULL)";
		$test = $db->exec($sql);
		echo "Table Pictures - Created!<br /><br />";

		$sql = "CREATE TABLE IF NOT EXISTS `comments` (
			`id_comment` int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			`id_pic` int(10) NOT NULL,
			`comment` varchar(100) NOT NULL,
			`login` varchar(30) NOT NULL)";
		$test = $db->exec($sql);
		echo "Table Comments - Created!<br /><br />";

		include("./fill.php");

} catch (PDOException $exception) {
	print "Error : " . $exception->getMessage() . ".";
	return (false);
}
echo '<a href="../index.php"> Retour à l accueil </a>';
?>