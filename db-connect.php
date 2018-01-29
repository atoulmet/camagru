<?php
require "config/database.php";
try
{
	$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
?>